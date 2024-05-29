<?php

namespace App\Models;

use App\Mail\TransaksiMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Roles
     *
     * @var string
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Pegawai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }

    /**
     * Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Notifikasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifikasi()
    {
        // if admin return all notifikasi
        if ($this->role === 'admin') {
            return [];
        }

        // Retrieve the pegawai object
        $pegawai = $this->pegawai;

        // Check if total_transaksi is less than min_transaksi and return notification
        if ($pegawai->total_transaksi < $pegawai->min_transaksi) {
            // Get current date and time
            $now = Carbon::now();

            // Format the date as 'd F Y H:i:s'
            $formattedDate = $now->format('d F Y');
            $data = [
                'message' => 'Total transaksi Anda kurang dari minimum transaksi yang ditentukan. Total transaksi Anda: ' . $pegawai->total_transaksi . ' Minimum transaksi: ' . $pegawai->min_transaksi,
                'date' => $formattedDate,
                'count' => 1,
                'name' => $this->getFullNameAttribute()
            ];
            $this->sendEmailNotifikasi($data);
            return $data;
        }

        return 0;
    }

    public function sendEmailNotifikasi($data)
    {
        $notifikasiTerakhir = NotifikasiModel::where('id_user', $this->id)->latest()->first();
        if (!$notifikasiTerakhir) {
            $email = new TransaksiMail($data);
            Mail::to($this->email)->send($email);
            NotifikasiModel::create([
                'id_user' => $this->id,
            ]);
        } else {
            $duaHariLalu = Carbon::now()->subDays(2);
            if ($notifikasiTerakhir->updated_at->lt($duaHariLalu)) {
                $email = new TransaksiMail($data);
                Mail::to($this->email)->send($email);
                $notifikasiTerakhir->touch();
            }
        }
    }
}