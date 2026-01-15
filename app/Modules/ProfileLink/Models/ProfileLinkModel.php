<?php

namespace App\Modules\ProfileLink\Models;

use CodeIgniter\Model;
use App\Modules\ProfileLink\Entities\ProfileLink;

class ProfileLinkModel extends Model
{
    protected $table = 'profile_links';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProfileLink::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'profile_id',
        'title',
        'url',
        'icon',
        'position',
        'click_count',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'profile_id' => 'required|integer',
        'title' => 'required|min_length[1]|max_length[100]',
        'url' => 'required|valid_url_strict',
        'icon' => 'permit_empty|max_length[50]',
        'position' => 'permit_empty|integer|greater_than_equal_to[0]',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Link basligi zorunludur.',
        ],
        'url' => [
            'required' => 'URL zorunludur.',
            'valid_url_strict' => 'Gecerli bir URL giriniz.',
        ],
    ];

    protected $skipValidation = false;

    public function getByProfileId(int $profileId): array
    {
        return $this->where('profile_id', $profileId)
            ->orderBy('position', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function getActiveByProfileId(int $profileId): array
    {
        return $this->where('profile_id', $profileId)
            ->where('is_active', 1)
            ->orderBy('position', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function incrementClickCount(int $id): bool
    {
        return $this->builder()
            ->where('id', $id)
            ->set('click_count', 'click_count + 1', false)
            ->update();
    }

    public function getNextPosition(int $profileId): int
    {
        $maxPosition = $this->selectMax('position')
            ->where('profile_id', $profileId)
            ->first();

        return ($maxPosition->position ?? 0) + 1;
    }

    public function updatePositions(array $positions): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($positions as $id => $position) {
            $this->update($id, ['position' => $position]);
        }

        $db->transComplete();
        return $db->transStatus();
    }

    public function getTotalClicksByProfileId(int $profileId): int
    {
        $result = $this->selectSum('click_count')
            ->where('profile_id', $profileId)
            ->first();

        return $result->click_count ?? 0;
    }

    public function getTopLinksByProfileId(int $profileId, int $limit = 5): array
    {
        return $this->where('profile_id', $profileId)
            ->orderBy('click_count', 'DESC')
            ->findAll($limit);
    }
}
