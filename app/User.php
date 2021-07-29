<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_cad_usuario';
    protected $primaryKey = 'id';
	public $timestamps = false;

    /**
	 * Overrides the method to ignore the remember token.
	*/
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute)
		{
			parent::setAttribute($key, $value);
		}
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'des_email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Verifica se o usuário é administrador **/
    public function isAdmin() {
        return (bool) $this->perfilAcesso->isAdmin();
    }

    /** Relations **/
    public function perfilAcesso()
    {
      return $this->hasOne(Models\Configuracoes\PerfilAcesso::class, 'id', 'id_perfil_acesso');
    }
}
