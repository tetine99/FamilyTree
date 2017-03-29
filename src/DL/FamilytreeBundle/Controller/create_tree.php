<?php
function createTree($relations,$people,$deep)
{

    $tree = array(
        "label" => $people->getLabel(),
        "relations" => array()

    );
    foreach ($relations as $rel){
        if($rel->getPeopleB()->getId()==$people->getId()){
            if ($deep > 0){
                $tree["relations"][$rel->getRelationship()->getName()] = createTree(
                    $relations,
                    $rel->getPeopleA(),
                    $deep-1
                );
            }
        }
    }
    return $tree;
}
?>