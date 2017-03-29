<?php
function createTree($relations,$people,$deep)
{
    // Vérification du nom et création d'un autre nom si besoin
    $label ="";
    $empty = false;
    if ($people==null){
        $empty = true;
        if ($deep==1){
            $label = "Grand ";
        }else if($deep==0){
            $label = "Arrière Grand ";
        }
    }else{
        $label = $people->getLabel();
    }
    // création de l'objet arbre
    $tree = array(
        "empty" => $empty,
        "label" => $label,
        "relations" => array()

    );
    if ($deep > 0){
        // remplissage de l'objet arbre en fonction des relations existantes dans la base
        foreach ($relations as $rel){
            if($rel->getPeopleB()->getId()==$people->getId()){
                $tree["relations"][$rel->getRelationship()->getName()] = createTree(
                    $relations,
                    $rel->getPeopleA(),
                    $deep-1
                );
            }
        }
    
        // remplissage de l'objet arbre  avec les valeurs par défaut
        if(!array_key_exists("Père",$tree["relations"])){
            $tree["relations"]["Père"] = createTree([],null,$deep-1);
        }
        if(!array_key_exists("Mère",$tree["relations"])){
            $tree["relations"]["Mère"] = createTree([],null,$deep-1);
        }
    }
    return $tree;
}
?>