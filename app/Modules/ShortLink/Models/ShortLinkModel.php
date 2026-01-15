<?php

namespace App\Modules\ShortLink\Models;

use CodeIgniter\Model;
use App\Modules\ShortLink\Entities\ShortLink;

class ShortLinkModel extends Model
{
    protected $table = 'short_links';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ShortLink::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'code',
        'target_url',
        'title',
        'click_count',
        'expires_at',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'code' => 'required|min_length[3]|max_length[20]|alpha_numeric|is_unique[short_links.code,id,{id}]',
        'target_url' => 'required|valid_url_strict',
        'title' => 'permit_empty|max_length[255]',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'Kisa kod zorunludur.',
            'is_unique' => 'Bu kod zaten kullaniliyor.',
            'alpha_numeric' => 'Kod sadece harf ve rakam icerebilir.',
        ],
        'target_url' => [
            'required' => 'Hedef URL zorunludur.',
            'valid_url_strict' => 'Gecerli bir URL giriniz.',
        ],
    ];

    protected $skipValidation = false;

    // Base62 characters for code generation
    protected string $base62Chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public function findByCode(string $code): ?ShortLink
    {
        return $this->where('code', $code)->first();
    }

    public function findValidByCode(string $code): ?ShortLink
    {
        $link = $this->findByCode($code);

        if ($link === null) {
            return null;
        }

        if (!$link->isValid()) {
            return null;
        }

        return $link;
    }

    public function getByUserId(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function incrementClickCount(int $id): bool
    {
        return $this->builder()
            ->where('id', $id)
            ->set('click_count', 'click_count + 1', false)
            ->update();
    }

    public function generateUniqueCode(int $length = 6): string
    {
        $maxAttempts = 100;
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $code = $this->generateRandomCode($length);

            if ($this->isCodeAvailable($code)) {
                return $code;
            }

            $attempts++;
        }

        // If still not unique, add timestamp suffix
        return $this->generateRandomCode($length - 2) . substr(time(), -2);
    }

    protected function generateRandomCode(int $length): string
    {
        $code = '';
        $max = strlen($this->base62Chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $code .= $this->base62Chars[random_int(0, $max)];
        }

        return $code;
    }

    public function isCodeAvailable(string $code, ?int $excludeId = null): bool
    {
        $builder = $this->builder()->where('code', $code);

        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    public function getTotalClicks(): int
    {
        $result = $this->selectSum('click_count')->first();
        return $result->click_count ?? 0;
    }

    public function getTotalClicksByUserId(int $userId): int
    {
        $result = $this->selectSum('click_count')
            ->where('user_id', $userId)
            ->first();

        return $result->click_count ?? 0;
    }

    public function getTopLinks(int $limit = 10): array
    {
        return $this->orderBy('click_count', 'DESC')
            ->findAll($limit);
    }

    public function getExpiredLinks(): array
    {
        return $this->where('expires_at IS NOT NULL')
            ->where('expires_at <', date('Y-m-d H:i:s'))
            ->findAll();
    }

    public function deactivateExpiredLinks(): int
    {
        return $this->builder()
            ->where('expires_at IS NOT NULL')
            ->where('expires_at <', date('Y-m-d H:i:s'))
            ->where('is_active', 1)
            ->set('is_active', 0)
            ->update();
    }
}
