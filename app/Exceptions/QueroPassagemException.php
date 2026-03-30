<?php

namespace App\Exceptions;

use Exception;

class QueroPassagemException extends Exception
{
    public static function failedToFetchStops(): self
    {
        return new self('Falha ao buscar paradas na API.', 503);
    }

    public static function failedToSearchTravels(): self
    {
        return new self('Falha ao buscar viagens na API.', 503);
    }

    public static function failedToFetchSeats(): self
    {
        return new self('Falha ao buscar poltronas na API.', 503);
    }
}