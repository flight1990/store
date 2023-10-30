<?php

namespace App\Repositories\Eloquent;

use Closure;
use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{

    protected Application $app;

    protected Builder|Model $model;

    abstract public function model(): string;

    /**
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function get($columns = ['*']): Collection
    {
        return $this->model
            ->select($columns)
            ->get();
    }

    public function paginate($limit = 15, $columns = ['*']): LengthAwarePaginator
    {
        return $this->model
            ->select($columns)
            ->paginate($limit)
            ->withQueryString();
    }

    public function find(int $id, $columns = ['*']): Model|null
    {
        return $this->model
            ->select($columns)
            ->findOrFail($id);
    }

    public function findByColumn(string $column, string $value, array $columns = ['*']): Model
    {
        return $this->model
            ->select($columns)
            ->where($column, $value)
            ->firstOrFail();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): Model
    {
        $model = $this->find($id);
        $model->delete();

        return $model;
    }

    public function min(string $column)
    {
        return $this->model->min($column);
    }

    public function max(string $column)
    {
        return $this->model->max($column);
    }

    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model
            ->updateOrCreate($attributes, $values);
    }

    public function with(array $relations): RepositoryInterface
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function withCount(string $relation): RepositoryInterface
    {
        $this->model->withCount($relation);

        return $this;
    }

    public function whereHas($relation, Closure $callback = null): RepositoryInterface
    {
        $this->model = $this->model->whereHas($relation, $callback);

        return $this;
    }

    public function limit(int $limit): RepositoryInterface
    {
        $this->model = $this->model->limit($limit);

        return $this;
    }

    public function whereColumn(string $column, int|string|null $value, string $operator = '='): RepositoryInterface
    {
        $this->model = $this->model->where($column, $operator, $value);

        return $this;
    }

    public function whereInColumn(string $column, array $values): RepositoryInterface
    {
        $this->model = $this->model->whereIn($column, $values);

        return $this;
    }

    public function whereNotInColumn(string $column, array $values): RepositoryInterface
    {
        $this->model = $this->model->whereNotIn($column, $values);

        return $this;
    }

    public function whereBetween(string $column, array $values): RepositoryInterface
    {
        $this->model = $this->model->whereBetween($column, $values);

        return $this;
    }

    public function orderBy($column, $direction = 'asc'): RepositoryInterface
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function orderByRaw(string $sql): RepositoryInterface
    {
        $this->model = $this->model->orderByRaw($sql);

        return $this;
    }
}
