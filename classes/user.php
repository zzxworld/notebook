<?php
class UserRepeatAccountError extends Exception {};
class UserInvalidAccountError extends Exception {};
class UserInvalidPasswordError extends Exception {};

class User
{
	public static function encryptPassword($text, $salt)
	{
		return md5($text.':'.$salt);
	}

	public static function create(array $params)
	{
        $total = DB::count('users', ['email' => $params['email']]);
		if ($total > 0) {
			throw new UserRepeatAccountError();
		}

        $salt = randString(8);
		$password = self::encryptPassword($params['password'], $salt);

		$query = DB::prepare('INSERT INTO users(email, password, salt, created_at)
			VALUES(:email, :password, :salt, :created_at)');
		$query->bindParam(':email', $params['email']);
		$query->bindParam(':password', $password);
		$query->bindParam(':salt', $salt);
		$query->bindParam(':created_at', date('Y-m-d H:i:s'));
		$query->execute();
	}

    public static function login($account, $password)
    {
        $query = DB::prepare('SELECT id, salt, password FROM users WHERE email=:account LIMIT 1');
        $query->bindParam(':account', $account);
        $query->execute();

        $result = $query->fetch();
        if (!$result) {
            throw new UserInvalidAccountError;
        }

        $password = self::encryptPassword($password, $result['salt']);
        if ($password != $result['password']) {
            throw new UserInvalidPasswordError;
        }

        return $result['id'];
    }
}
