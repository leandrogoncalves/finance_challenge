<?php


namespace App\Repositories;


use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $model;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return Arrayable
     */
    public function findAll():Arrayable
    {
        return $this->model->with('current_balance')->get();
    }

    /**
     * @return mixed
     */
    public function findAllPaginated()
    {
        return $this->model->with('current_balance')->paginate();
    }

    /**
     * @param $id
     * @return Model
     */
    public function findById(int $id):Model
    {
        $user = $this->model->with('current_balance')->find($id);
        if(!$user instanceof User){
            throw new NotFoundException('Usuário não encontrado');
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
            $this->model = $this->findById($id);
        }
        $this->model->fill($data)->save();
        return $this->model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool
    {
        $this->model = $this->findById($id);
        return $this->model->delete();
    }
}
