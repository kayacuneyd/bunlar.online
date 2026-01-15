<?php

namespace App\Modules\Profile\Models;

use CodeIgniter\Model;
use App\Modules\Profile\Entities\Profile;

class ProfileModel extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Profile::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'username',
        'display_name',
        'bio',
        'avatar',
        'theme',
        'ga_measurement_id',
        'view_count',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'username' => 'required|min_length[3]|max_length[50]|alpha_dash|is_unique[profiles.username,id,{id}]',
        'display_name' => 'required|min_length[2]|max_length[100]',
        'bio' => 'permit_empty|max_length[500]',
        'theme' => 'permit_empty|in_list[minimal,dark,colorful,gradient]',
        'ga_measurement_id' => 'permit_empty|max_length[50]',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Kullanici adi zorunludur.',
            'min_length' => 'Kullanici adi en az 3 karakter olmalidir.',
            'is_unique' => 'Bu kullanici adi zaten kullaniliyor.',
            'alpha_dash' => 'Kullanici adi sadece harf, rakam, tire ve alt cizgi icerebilir.',
        ],
    ];

    protected $skipValidation = false;

    // Reserved usernames that cannot be used
    protected array $reservedUsernames = [
        'admin', 'login', 'logout', 'register', 'api', 'l',
        'settings', 'dashboard', 'profile', 'profiles',
        'link', 'links', 'short', 'analytics', 'help',
        'about', 'contact', 'terms', 'privacy', 'static',
        'assets', 'uploads', 'images', 'css', 'js',
    ];

    public function findByUsername(string $username): ?Profile
    {
        return $this->where('username', $username)->first();
    }

    public function findByUserId(int $userId): ?Profile
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getActiveProfiles(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function incrementViewCount(int $id): bool
    {
        return $this->builder()
            ->where('id', $id)
            ->set('view_count', 'view_count + 1', false)
            ->update();
    }

    public function isUsernameAvailable(string $username, ?int $excludeId = null): bool
    {
        // Check reserved usernames
        if (in_array(strtolower($username), $this->reservedUsernames)) {
            return false;
        }

        $builder = $this->builder()->where('username', $username);
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    public function getReservedUsernames(): array
    {
        return $this->reservedUsernames;
    }

    public function generateUniqueUsername(string $displayName, ?int $excludeId = null): string
    {
        $username = mb_strtolower($displayName);
        $username = preg_replace('/[^a-z0-9\s-]/', '', $username);
        $username = preg_replace('/[\s_]+/', '-', $username);
        $username = preg_replace('/-+/', '-', $username);
        $username = trim($username, '-');

        if (empty($username)) {
            $username = 'user';
        }

        $originalUsername = $username;
        $counter = 1;

        while (!$this->isUsernameAvailable($username, $excludeId)) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
