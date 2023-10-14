<?php

function printLine(...$values)
{
    echo var_export(implode('', $values), true) . PHP_EOL;
}

interface ContaInteface
{
    public function depositar(float $valor): static;
    public function retirar(float $valor): bool;
    public function saldo(bool $formated = false): string|float;
    public function extrato(?DateTime $from, ?DateTime $to): array;
}

abstract class Conta implements ContaInteface
{
    protected array $transacoes = [];

    public function __construct(
        protected int $number,
        protected float $saldo,
    ) {
        //
    }

    protected function addLog(
        string $type,
        string|int|float|null $value,
        bool|null $success = true,
    ) {
        $this->transacoes[] = [
            'account_type' => static::class,
            'account_number' => $this->number,
            'type' => $type,
            'value' => $value,
            'success' => boolval($success),
            'date' => new DateTime('now'),
        ];
    }

    public function depositar(float $valor): static
    {
        $this->addLog('depósito', $valor);

        $this->saldo += $valor;

        return $this;
    }

    public function retirar(float $valor): bool
    {
        $this->addLog('retirada', $valor);
        $this->saldo -= $valor;

        return true;
    }

    public function saldo(bool $formated = false): string|float
    {
        return $formated ? number_format($this->saldo, 2, ',', '.') : $this->saldo;
    }

    public function extrato(?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->transacoes;
    }
}

class ContaCorrente extends Conta
{
}

class ContaPoupanca extends Conta
{
}

$contas = [
    [
        'number' => 789798799,
        'type' => 'cc',
        'balance' => 485,
    ]
];

$cc = new ContaCorrente($contas[0]['number'], $contas[0]['balance']);

printLine('Saldo: ', $cc->saldo(true));

$cc->retirar(50);
printLine('Saldo: ', $cc->saldo(true));

$cc->retirar(1500.47);
printLine('Saldo: ', $cc->saldo(true));

$cc->retirar($cc->saldo());
printLine('Saldo: ', $cc->saldo(true));

$cc->retirar(14);
printLine('Saldo: ', $cc->saldo(true));

$cc->depositar(140);
printLine('Saldo: ', $cc->saldo(true));

printLine('extrato: ', var_export($cc->extrato(), true));
