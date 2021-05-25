<?php


namespace App\Repositories;


use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function create()
    {
        return $this->user;
    }

    /**
     * @return Arrayable
     */
    public function findAll(array $with = null):Arrayable
    {
        $queryBuilder = $this->user::query();
        if($with){
            $queryBuilder = $queryBuilder->with($with);
        }
        return $queryBuilder->get();
    }

    /**
     * @return mixed
     */
    public function findAllPaginated(array $with = null)
    {
        $queryBuilder = $this->user::query();
        if($with){
            $queryBuilder = $queryBuilder->with($with);
        }
        return $queryBuilder->paginate();
    }

    /**
     * @param $id
     * @return Model
     */
    public function findById(int $id, array $with = null):Model
    {
        $queryBuilder = $this->user::query();
        if($with){
            $queryBuilder = $queryBuilder->with($with);
        }
        $user = $queryBuilder->find($id);
        if(!$user instanceof User){
            throw new NotFoundException('Conta não encontrada');
        }
        return $user;
    }

    /**
     * @param array $data
     * @param null $id
     * @return Model
     */
    public function store(array $data, int $id = null):Model
    {
        if($id){
            $this->user = $this->findById($id);
        }
        $this->user->fill($data)->save();
        return $this->user;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool
    {
        $this->user = $this->findById($id);
        return $this->user->delete();
    }
}
