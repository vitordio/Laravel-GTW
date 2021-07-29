<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Cliente extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'tb_cad_clientes';
    protected $primaryKey = 'id';
	public $timestamps = false;
    protected $guard = 'cliente';

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
        'des_login', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /** Mutators **/
    public function getFlgAtivoAttribute($flg_ativo)
    {
        return $flg_ativo == 'S' ? 'Sim' : 'Não';
    }

    public function getDesCpfCnpjAttribute($des_cpf_cnpj)
    {
        if (strlen($des_cpf_cnpj) === 11) {
        $des_cpf_cnpj = substr($des_cpf_cnpj, 0, 3) . '.' . substr($des_cpf_cnpj, 3, 3) . '.' . substr($des_cpf_cnpj, 6, 3) . '-' . substr($des_cpf_cnpj, 9);
        } else {
        $des_cpf_cnpj = substr($des_cpf_cnpj, 0, 2) . '.' . substr($des_cpf_cnpj, 2, 3) . '.' . substr($des_cpf_cnpj, 5, 3) . '/' . substr($des_cpf_cnpj, 8, 4) . '-' . substr($des_cpf_cnpj, 12, 2);
        }

        return $des_cpf_cnpj;
    }

    public function getDesTelefoneAttribute($des_telefone)
    {
        if ($des_telefone)
        return '(' . substr($des_telefone, 0, 2) . ')' . substr($des_telefone, 2, 4) . '-' . substr($des_telefone, 6);
    }
}
