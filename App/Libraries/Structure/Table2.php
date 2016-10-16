<?php
namespace App\Libraries\Structure;

use \App\Libraries\Interfaces;
use \App\Libraries\Structure\Table\Tr;

/**
 * Table html au format réduit, uniquement des tr
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \Tests\Units\App\Libraries\Structure\Table
 * faire un autoBuild pour la totalité de la table
 */
class TableMini extends AHtmlElement implements Interfaces\IHeritable
{
    /**
     * @var array Liste d'enfants <tr> de la table
     */
    private $children = [];

    /**
     * {@inheritdoc}
     * @see Interfaces\IRenderable
     */
    public function render()
    {
        echo '<table id="' .  $this->getId() . '"';
        $this->renderClasses();
        $this->renderAttributes();
        echo '>';
        foreach ($this->children as $child) {
            if ($child instanceof Interfaces\IRenderable) {
                $child->render();
            } else {
                /* 1.9 TODO: On peut ajouter n'importe quel fils quitte à faire n'importe quoi,
                c'est à but transitoire. À terme, il sera nécessaire de n'autoriser
                que ce qui peut être fils de <table> (thead, tbody, tfoot, tr) */
                echo $child;
            }
        }
        echo '</table>';
    }

    /**
     * {@inheritdoc}
     * @see Interfaces\IHeritable
     */
    public function addChildren(array $children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see Interfaces\IHeritable
     * @throws \Exception Si le fils injecté n'est pas de type Tr
     */
    public function addChild($child)
    {
        if ($child instanceof Tr) {
            $this->children[] = $child;
        } else {
            throw new \Exception('Child not a Tr object', 1);
        }
    }

/*
 * TODO: la spec HTML5 définit que l'on peut avoir soit un format complet (groupes thead, tbody, tfoot) soit une syntaxe courte avec seulement des tr.
 * Il faut donc mettre cette classe en abstraite et avoir deux fils implémentant ce fait
 */
}
