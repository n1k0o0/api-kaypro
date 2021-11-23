<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * @param  array  $data
     * @param  int|null  $limit
     * @return Collection|LengthAwarePaginator|array
     */
    public function getUsers(array $data, int $limit = null): Collection|LengthAwarePaginator|array
    {
        $query = User::query()
                ->when(
                        isset($data['first_name']),
                        fn(Builder $query) => $query->where('first_name', 'LIKE', '%'.$data['first_name'].'%')
                )
                ->when(
                        isset($data['last_name']),
                        fn(Builder $query) => $query->where('last_name', 'LIKE', '%'.$data['last_name'].'%')
                )
                ->when(
                        isset($data['phone']),
                        fn(Builder $query) => $query->where('phone', 'LIKE', '%'.$data['phone'].'%')
                )
                ->when(
                        isset($data['email']),
                        fn(Builder $query) => $query->where('email', 'LIKE', '%'.$data['email'].'%')
                )
                ->when(
                        isset($data['sort']),
                        fn(Builder $query) => $query->orderBy($data['sort'], $data['sort_type'])
                );

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
