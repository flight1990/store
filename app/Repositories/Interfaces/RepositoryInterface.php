<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function get($columns = ['*']);

    public function paginate($limit = 15, $columns = ['*']);

    public function find(int $id, $columns = ['*']);

    public function findByColumn(string $column, string $value, array $columns = ['*']);

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function min(string $column);

    public function max(string $column);

    public function updateOrCreate(array $attributes, array $values = []);

    public function with(array $relations): self;

    public function withCount(string $relation): self;

    public function whereHas($relation, \Closure $callback = null): self;

    public function limit(int $limit): self;

    public function whereColumn(string $column, int|string|null $value, string $operator = '='): self;

    public function whereInColumn(string $column, array $values): self;

    public function whereNotInColumn(string $column, array $values): self;

    public function whereBetween(string $column, array $values): self;

    public function orderBy($column, $direction = 'asc'): self;

    public function orderByRaw(string $sql): self;
}
