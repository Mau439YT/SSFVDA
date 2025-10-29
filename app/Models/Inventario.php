<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Inventario extends Model
{
    use Prunable;
    use SoftDeletes;

    protected $table = 'Inventario';
    protected $fillable = [
        'id_usuarios',
        'Nombre',
        'Url_Img',
        'Tipo',
        'Activo',
    ];
    protected $hidden = [
        'Tipo',
        'Activo',
    ];

    public function esImagen() : bool
    {
        return $this->Tipo === 'Imagen';
    }

    public function esVideo() : bool
    {
        return $this->Tipo === 'Video';
    }

    public function esDocumento() : bool
    {
        return $this->Tipo === 'Documento';
    }

    public function esAudio() : bool
    {
        return $this->Tipo === 'Audio';
    }

    public function prunable()
    {
        return static::where('created_at', '<', now()->subDays(7));
    }
    protected function pruning(): void
    {
        if ($this->Url_Img) {
            Storage::disk('public')->delete($this->Url_Img);
        }
    }
}
