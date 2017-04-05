<?php

function createTree( $relations, $people, $deep )
{
    $label = "";
    $empty = false;
    $image = false;
    if ($people == null){
        // Si l'objet people n'existe pas, on l'indique avec empty à true
        $empty = true;
        // On génère un label en fonction de la profondeur
        // c'est la macro de twig qui concaténera ce label avec la
        // catégorie correspondante : Père ou Mère
        if ($deep == 3){ // Premier niveau
            $label = "Enfant";
        }else if($deep == 1){
            $label = "Grand ";
        }else if($deep == 0){ // Dernier niveau
            $label = "Arrière Grand ";
        }
    }else{
        // Si l'objet people existe, on récupère son Label (Prénom + Nom)
        $label = $people->getLabel();
        if ($people->getImage() != null){
            // Si l'image est présente, on la récupère
            $image = $people->getImage();
        }
    }
    // création de l'arbre local
    $tree = array(
        "empty" => $empty, // Object vide ?
        "label" => $label, // Texte qui sera affiché si aucune image
        "image" => $image, // Nom de l'image ou false
        "relations" => array() // Sous arbre rangé dans une clef "Père" ou "Mère"
    );
    if ($deep > 0){ // Si ce n'est pas le dernier niveau
        // remplissage de l'arbre local en fonction des relations existantes dans la base
        foreach ($relations as $rel){
            if($rel->getPeopleB()->getId() == $people->getId()){
                $tree["relations"][$rel->getRelationship()->getName()] = createTree(
                    $relations,
                    $rel->getPeopleA(),
                    $deep-1
                );
            }
        }
        // remplissage de l'arbre local  avec les valeurs par défaut
        if(!array_key_exists( "Père", $tree["relations"] )){
            $tree["relations"]["Père"] = createTree( [], null, $deep-1 );
        }
        if(!array_key_exists( "Mère", $tree["relations"] )){
            $tree["relations"]["Mère"] = createTree( [], null, $deep-1 );
        }
    }
    return $tree;
}

?>