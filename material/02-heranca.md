```php
class BaseCarro
{
    protected $cor;
    protected $fabricante;
    protected $modelo;
    protected $motorTipo;

    final public function getModelo()
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
```
