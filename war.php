<?php

// ООП - определение, прочитать WIKI - сказать что непонятно в вопросе ДЗ
// для описания алгоритма используются взаимодействующие объекты (экземпляры класса)
// методы для взаимодействия публичные - доступны, методы внутренней реализации - скрытые
// логика алгоритма выглядит проще, если скрывать незначительные детали и выстраивать взаимодействие между объектами на разных уровнях

// https://ru.wikipedia.org/wiki/%D0%9E%D0%B1%D1%8A%D0%B5%D0%BA%D1%82%D0%BD%D0%BE-%D0%BE%D1%80%D0%B8%D0%B5%D0%BD%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%BC%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5
// https://habr.com/ru/post/87119/
// https://habr.com/ru/post/87205/
// http://www.codenet.ru/progr/cpp/ipn.php
// https://medium.com/@volkov97/%D0%BE%D1%81%D0%BD%D0%BE%D0%B2%D0%BD%D1%8B%D0%B5-%D0%BA%D0%BE%D0%BD%D1%86%D0%B5%D0%BF%D1%86%D0%B8%D0%B8-%D0%BE%D0%BE%D0%BF-9c61d16e693b

// !абстракция
// инкапсуляция
// наследование
// полиморфизм

// OOP PHP https://refactoring.guru/ru/design-patterns/php

// Практики: (DRY) KISS SOLID
// https://habr.com/ru/company/itelma/blog/546372/

//------------------------------------------------------------------------------------------------------------------



// TODO намеренно плохой код! задача - отрефакторить, используя известные вам техники организации кода

// Войска: пехота, конница, лучники.
// Свойства: жизни, броня, урон
// interface Unitinterface
// {
//     public function __construct(int $count);
//     public function get_damage_health (string $unit_type, int $count);
// }
class Unit
{
    public int $correct1 = 1;
    public float $correct2 = 1;
    public $count;
    public $health;
    public $armour;
    public $damage;
    public $unit_type;
    public $unit = [];
    public function __construct(int $count){
         $this->count = $count;
    }
    public function set_correction (string $correct)
    {
        if ($correct=='ice')
        {
            $this->correct1= 0;
        }
        if ($correct=='rain')
        {
            $this->correct2= 0.5;
        }

    }
    public function get_damage_health (string $unit_type, int $count)
    {
      $this->unit_type = $unit_type;
      if ($this->unit_type=='pehota')
      {
        $this->health = 100;
        $this->armour = 10;
        $this->damage = 10;
      }
      elseif ($this->unit_type=='konnica')
      {
        $this->health = 300;
        $this->armour = 30*$this->correct1;
        $this->damage = 30;
      }
      else
      {
        $this->health = 100;
        $this->armour = 5;
        $this->damage = 20*$this->correct2;;
      }
      $this->count = $count;
      $this->damage = $this->damage*$this->count;
      $this->health = $this->health*$this->count+$this->armour*$this->count;
      $this->unit = ['damage'=>$this->damage, 'health'=>$this->health];
      return $this->unit;
    }
}
class User extends Unit
{
    public $name;
    public $pehota;
    public $luchniki;
    public $konnica;
    public $damage;
    public $health;
    public $correction;
    public function __construct(string $name, int $pehota, int $luchniki, int $konnica, string $correction)
    {
        $this->name = $name;
        $this->pehota = $pehota;
        $this->luchniki = $luchniki;
        $this->konnica = $konnica;
        $this->correction= $correction;
    }
    public function userdata ()
    {
        parent::set_correction ($this->correction);
        $respehota = parent::get_damage_health ('pehota', $this->pehota);
        $resluchniki = parent::get_damage_health ('luchniki', $this->luchniki);
        $reskonnica = parent::get_damage_health ('konnica', $this->konnica);
        $pehota_damage = $respehota['damage'];
        $pehota_health = $respehota['health'];
        $luchniki_damage = $resluchniki['damage'];
        $luchniki_health = $resluchniki['health'];
        $konnica_damage = $reskonnica['damage'];
        $konnica_health = $reskonnica['health'];
        $this->damage =  $pehota_damage+ $luchniki_damage+  $konnica_damage;
        $this->health =   $pehota_health+  $luchniki_health+  $konnica_health;
        $userdata= [
            'name'=>$this->name,
            'pehota'=>$this->pehota,
            'luchniki'=>$this->luchniki,
            'konnica'=>$this->konnica,
            'pehota_damage'=>$pehota_damage,
            'luchniki_damage'=>$luchniki_damage,
            'konnica_damage'=>$konnica_damage,
            'pehota_health'=>$pehota_health,
            'luchniki_health'=>$luchniki_health,
            'konnica_health'=>$konnica_health,
            'total_damage'=>$this->damage,
            'total_health'=>$this->health
        ];
        return $userdata;
    }
}

class War
{
    public array $user1;
    public array $user2;
    public int $type_war;
    public function __construct(array $user1,array $user2, int $type_war)
    {
        $this->user1= $user1;
        $this->user2= $user2;
        $this->type_war= $type_war;
    }
    public function WarResult()
    {
        if ($this->type_war==1)
        {
            $health1= $this->user1['total_health'];
            $health2= $this->user2['total_health'];
            $damage1= $this->user1['total_damage'];
            $damage2= $this->user2['total_damage'];
            $duration = 0;
            while ($health1 >= 0 && $health2 >= 0) {
                $health1 -= $damage2;
                $health2 -= $damage1;
                $duration++;
            }
            $this->user1['health_after']= $health1;
            $this->user2['health_after']= $health2;
            $this->user1['duration']= $duration;
            if ($health1>$health2)
            {
                $this->user1['result']= 'winner';
                $this->user2['result']= 'looser';
            }
            else
            {
                $this->user2['result']= 'winner';
                $this->user1['result']= 'looser'; 
            }
            $result= ['user1'=>$this->user1, 'user2'=>$this->user2];
            return $result;
        }
        elseif ($this->type_war==2)
        {
            $health1_p= $this->user1['pehota_health'];
            $health2_p= $this->user2['pehota_health'];
            $damage1_p= $this->user1['pehota_damage'];
            $damage2_p= $this->user2['pehota_damage'];
            $duration = 0;
            while ($health1_p >= 0 && $health2_p >= 0) {
                $health1_p -= $damage2_p;
                $health2_p -= $damage1_p;
                $duration++;
            }
            $health1_l= $this->user1['luchniki_health'];
            $health2_l= $this->user2['luchniki_health'];
            $damage1_l= $this->user1['luchniki_damage'];
            $damage2_l= $this->user2['luchniki_damage'];
            while ($health1_l >= 0 && $health2_l >= 0) {
                $health1_l -= $damage2_l;
                $health2_l -= $damage1_l;
                $duration++;
            }
            $health1_k= $this->user1['konnica_health'];
            $health2_k= $this->user2['konnica_health'];
            $damage1_k= $this->user1['konnica_damage'];
            $damage2_k= $this->user2['konnica_damage'];
            while ($health1_k >= 0 && $health2_k >= 0) {
                $health1_k -= $damage2_k;
                $health2_k -= $damage1_k;
                $duration++;
            }
            $this->user1['health_after']= $health1_p + $health1_l + $health1_k;
            $this->user2['health_after']= $health2_p + $health2_l + $health2_k;
            $this->user1['duration']= $duration;
            if ($this->user1['health_after']>$this->user2['health_after'])
            {
                $this->user1['result']= 'winner';
                $this->user2['result']= 'looser';
            }
            else
            {
                $this->user2['result']= 'winner';
                $this->user1['result']= 'looser'; 
            }
            $result= ['user1'=>$this->user1, 'user2'=>$this->user2];
            return $result;
        }
        else
        {
            return 'incorrect data';
        }
    }
}
$correction = ''; // 'ice' - лед, 'rain' дождь
$user1=(new User ('Marat', 200, 300, 100, $correction))->userdata(); // в формате "имя", пехота, лучники, конница
$user2=(new User ('Taram', 150, 350, 200, $correction))->userdata();
$type_war= 1; //1 - суммарный подсчет, 2 -сражение каждой линии до выживания
$result= (new War ( $user1, $user2, $type_war))->WarResult(); //array $user1,array $user2, int $type_war
$user1_res= $result['user1'];
$user2_res=  $result['user2'];

?>
<table border="1">
    <tr>
        <th></th>
        <th><?=$user1_res['name']?></th>
        <th><?=$user2_res['name']?></th>
    </tr>
    <tr>
        <th>Army units:</th>
        <td>pehota (<?=$user1_res['pehota']?>), luchniki(<?=$user1_res['luchniki']?>), konnica(<?=$user1_res['konnica']?>)</td>
        <td>pehota (<?=$user2_res['pehota']?>), luchniki(<?=$user2_res['luchniki']?>), konnica(<?=$user2_res['konnica']?>)</td>
    </tr>
    <tr>
        <th>Health after <?=$user1_res['duration']?> hits:</th>
        <td><?=$user1_res['health_after']?></td>
        <td><?=$user2_res['health_after']?></td>
    </tr>
    <tr>
        <th>Result</th>
        <td><?=$user1_res['result']?></td>
        <td><?=$user2_res['result']?></td>
    </tr>
</table>
