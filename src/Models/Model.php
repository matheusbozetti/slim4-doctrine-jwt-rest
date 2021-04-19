<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

class Model implements \JsonSerializable
{
    use \App\Models\Traits\TimestampableModel;
    /**
     * @GeneratedValue(strategy="UUID")
     * @Id
     * @Column(name="id", type="guid", unique=true)
     */
    protected $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function jsonSerialize(): array
    {
        return ['Implements' => 'me'];
    }
}
