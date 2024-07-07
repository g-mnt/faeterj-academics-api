<?php

namespace App;

enum ArticleStatusesEnum: string
{
    case Pending = 'Pendente';
    case Approved = 'Aprovado';
    case Rejected = 'Rejeitado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
