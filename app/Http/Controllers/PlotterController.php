<?php
/**
 * Created by PhpStorm.
 * User: rachid
 * Date: 28/10/15
 * Time: 15:31
 */

namespace App\Http\Controllers;


use App\Models\Relation;
use App\Models\Plot;
use App\Models\Relations\MarriedTo;
use App\Models\Relations\ParentOf;
use App\Models\Relations\SiblingOf;
use App\Models\Settings\Personnage;
use Illuminate\Support\Collection;

class PlotterController extends Controller {

    public function getTest(){
        $numberInitial = 200;
        $numberMarried = floor($numberInitial * 10/100);
        $genders = [Personnage::GENDER_FEMALE, Personnage::GENDER_MALE];
        $chars = new Collection();
        for($i = 0; $i<$numberInitial; $i++){
            $char = new Personnage();
            $chars->push($char);
            $char->setGender($genders[array_rand($genders)]);
            $char->setAge(random_int(1, 60));
            $char->setName($i);
        }

        //Create some marriages
        foreach($chars as $char){
            if($char->age > 15){
                $numberMarried--;
                $spouse = new Personnage();
                $spouse->setAge(max(15,random_int($char->age - 5, $char->age + 5)));
                $spouse->setGender($char->gender == Personnage::GENDER_MALE ? Personnage::GENDER_FEMALE:Personnage::GENDER_MALE);
                $spouse->setName("Spouse $numberMarried");
                $relation = new MarriedTo($spouse, $char);
                $spouse->addRelation($relation);
                $chars->push($spouse);

                //Get them some babies!
                $totalBabies = random_int(0, min(abs($char->age - $spouse->age), 5));
                $siblings = [];
                for($i=0; $i<$totalBabies; $i++){
                    $child = new Personnage();
                    $child->setGender($genders[array_rand($genders)]);
                    $child->setName("Child $numberMarried.$i");
                    $relation1 = new ParentOf($char, $child);
                    $relation2 = new ParentOf($spouse, $child);
                    $char->addRelation($relation1);
                    $spouse->addRelation($relation2);
                    $chars->push($child);

                    foreach($siblings as $sibling){
                        $relation = new SiblingOf($sibling, $child);
                        $sibling->addRelation($relation);
                    }
                    $siblings[] = $child;
                }
            }

            if($numberMarried <= 0){
                break;
            }

        }



        /*$man1 = new Personnage();
        $woman1 = new Personnage();

        $man1->setName('man1');
        $woman1->setName('woman1');

        $man1->setAge(random_int(20, 50));
        $woman1->setAge(max(15,random_int($man1->age - 5, $man1->age + 5)));

        $married = new MarriedTo($man1, $woman1);
        $man1->addRelation($married);*/

        echo implode('<br/>', $chars->toArray());
    }

}