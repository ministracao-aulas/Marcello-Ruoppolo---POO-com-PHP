<?php

class BaseCarro
{
    protected $cor;
    protected $fabricante;
    protected $modelo;
    protected $motorTipo;

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getMotorTipo()
    {
        return $this->motorTipo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }
}

class CeltaoCarro extends BaseCarro
{
    public function getModelo()
    {
        return "{$this->modelo} - {$this->getMotorTipo()}";
    }
}

final class NRedis
{
    public function __construct(
        protected string $host,
        protected string $user,
        protected string $password,
        protected int|string $port = 3306,
    ) {
        //
    }

    public function getConnectionString()
    {
        return implode(
            '',
            [
                'tcp://',
                $this->user,
                ':',
                $this->password,
                '@',
                $this->host,
                ':',
                $this->port,
            ]
        );
    }
}

// $redis = new NRedis('fdkgu', 'edfd', 'dfdf', '546');
// $redis->getConnectionString();

interface ModelInterface
{
    public function setTable(string $table): static;
    public function getTable(): string;
}
trait ModelTableTrait
{
    protected ?string $table = null;

    public function setTable(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        return $this->table ?? '';
    }
}

abstract class Model implements ModelInterface
{
    use ModelTableTrait;

    public function first(): ?object
    {
        return new stdClass();
    }
}

class Produtos extends Model
{
}

class User extends Model
{
    public function first(): ?object
    {
        return new class() {};
    }
}

class AdminUser extends User
{}

$obj = new AdminUser();
$obj->setTable('abc');

// $res = $obj
//     ->setTable('abc');

// die(get_class($res));
$obj = (($obj ?? null) ?: null);
die(
    // (is_object($obj) ? $obj : null)?->getTable()
    // (($res ?? null) ?: null)?->getTable()
    get_class($obj->first())
    . PHP_EOL
);


// ?-> null safe
// ?? null coalesce
// ?: elvis operator
// condtion ? if true : if false -> ternary
