<?php

namespace Felipe\Repository;
use Felipe\Entity\User;
use PDO;
class UserRepository
{
    public function __construct(private PDO $pdo)
    {
        
    }

    public function add(User $user): bool
    {
        $statement = $this->pdo->prepare('INSERT INTO users(email,password) VALUES(:email,:password);');
        $statement->bindValue('email',$user->email);
        $statement->bindValue('password',$user->password);
        $result = $statement->execute();

        $id = $this->pdo->lastInsertId();

        $user->setId(intval($id));
        return $result;
    }

    public function remove(int $id): bool
    {
        $sql = 'DELETE FROM users WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('id',$id);
        return $statement->execute();
    }

    public function update(User $users): bool
    {
        $sql = 'UPDATE users SET email = :email, password = :password WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('email',$users->email);
        $statement->bindValue('password',$users->password);
        $statement->bindValue('id',$users->id,PDO::PARAM_INT);
        return $statement->execute();
    }
    /**
     * @return User[]
     */
    public function all(): array
    {
        $usersList = $this->pdo->query('SELECT * FROM users;')->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            function (array $usersData){
                $user = new User($usersData['email'],$usersData['password']);
                $user->setId($usersData['id']);

                return $user;
            },
            $usersList
        );
    }
    public function find(string $email)
    {
        
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email;');
        $statement->bindValue('email',$email);
        $statement->execute();
        //return $this->hydrateUser();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function checkHash(int $id, string $password)
    {
        if (password_needs_rehash($password,PASSWORD_ARGON2ID)){
            $statement = $this->pdo->prepare('UPDATE users SET password= :password WHERE id = :id;');
            $statement->bindValue('password',$password,PASSWORD_ARGON2ID);
            $statement->bindValue('id',$id);
            $statement->execute();
        }
    }
    private function hydrateUser(array $usersData): User
    {
        $user = new User($usersData['email'],$usersData['password']);
        $user->setId($usersData['id']);
        return $user;
    }
}