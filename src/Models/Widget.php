<?php


namespace DenisKisel\LaravelAdminWidget\Models;


use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = ['code', 'name', 'content'];
}
