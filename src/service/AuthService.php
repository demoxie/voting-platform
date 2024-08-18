<?php

namespace VotingPlatform\service;

use VotingPlatform\config\env\Env;
use VotingPlatform\config\jwt\Jwts;
use VotingPlatform\config\redis\Redis;
use VotingPlatform\service\IAuthService;
use VotingPlatform\config\db\DbConfig;
use VotingPlatform\config\queries\QuerySelector;
use VotingPlatform\dto\LoginRequest;
use VotingPlatform\dto\SignupRequest;
use VotingPlatform\dto\UserDetails;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\model\User;
use VotingPlatform\repository\UserRepository;

class AuthService implements IAuthService
{
    private DbConfig $config;
    use QuerySelector;
    use UserRepository;
    public function __construct(){
        $this->config = new DbConfig();
    }

    /**
     * @throws APIException
     */
    public function authenticateUser(LoginRequest $request): UserDetails{
        $user_details = $request;
        $username = $user_details->getEmail();
        $password = $user_details->getPassword();
        $user = $this->getUserByEmail($username);
        $exist = $user instanceof User;
        if ($exist) {
            if (password_verify($password, $user->getPassword())) {
                $token = Jwts::sign([
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                ]);
                Redis::client()->set(
                    'token:'. $token,
                    $token,
                    'EX',
                    Env::get("REDIS_TTL")
                );
                return new UserDetails(
                    $user->getId(),
                    $user->getName(),
                    $user->getUsername(),
                    $user->getEmail(),
                    $token,
                    $user->getCreatedAt(),
                    $user->getUpdatedAt()
                );
            } else {
                error_log(
                    "Failed to authenticate user: ". $username,
                );
                throw new APIException("Password does not match",400);
            }
        }else{
            error_log(
                "Failed to authenticate user: ". $username,
            );
            throw new APIException("User does not exist",404);
        }
    }

    /**
     * @throws APIException
     */
    public function logout(string $token): string
    {
        try {
            Jwts::validateToken($token);
            $payload = Jwts::decode($token);
            Redis::client()->del('token:' . $payload['id']);
            return "Logged out successfully";
        } catch (\Exception $e) {
            error_log(
                "Failed to logout: ". $e->getMessage(),
            );
            throw new APIException("Failed to logout",500);
        }
    }

    /**
     * @param SignupRequest $request
     * @return UserDetails
     * @throws APIException
     */

    public function signup(SignupRequest $request): UserDetails
    {
        $user_details = $request;
        $name = $user_details->getName();
        $username = $user_details->getUsername();
        $email = $user_details->getEmail();
        $password = $user_details->getPassword();

        $user = $this->getUserByEmail($email);
        $exist = $user;
        if ($exist) {
            error_log(
                "Email already exists: ". $email,
            );
            throw new APIException("Email already exists",409);
        }

        $newUser = $this->save([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        if ($newUser){
            return new UserDetails(
                $newUser->getId(),
                $newUser->getName(),
                $newUser->getUsername(),
                $newUser->getEmail(),
                null,
                $newUser->getCreatedAt(),
                $newUser->getUpdatedAt()
            );
        }
        error_log(
            "Failed to create user with email: ". $email,
        );
        throw new APIException("Failed to create user",500);
    }

    /**
     * @throws APIException
     */
    public static function verifyJwtToken(?string $token): bool
    {
        if (empty($token)) {
            throw new APIException("Token is empty", 401);
        }

        try {
            // Decode the JWT token
            Jwts::validateToken($token);
            $redisToken = Redis::client()->get('token:'.$token);
            if (empty($redisToken)) {
                throw new APIException("Token not found in Redis", 401);
            }
            return true;

        } catch (\Exception $e) {
            error_log($e);
            throw new APIException("Invalid token: ". $e->getMessage(), 401);
        }
    }


    public static function extractTokenFromHeader(): ?string
    {
        $token = null;
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = trim($_SERVER['HTTP_AUTHORIZATION']);
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7); // Remove 'Bearer ' prefix
            }
        } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authHeader = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7); // Remove 'Bearer ' prefix
            }
        }
        return $token;
    }

}