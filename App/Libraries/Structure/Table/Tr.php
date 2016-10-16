<?php
namespace App\Libraries\Structure\Table;

use App\Libraries\Interfaces;
use App\Libraries\Structure\AHtmlElement;

/**
 * Ligne d'une table html
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \Tests\Units\App\Libraries\Structure\Table\Thead
 */
class Tr extends AHtmlElement implements Interfaces\IHeritable
{
    /**
     * Liste d'enfants de la ligne
     *
     * @var array
     */
    private $children = [];

    //private $nombreCells;

    /**
     * {@inheritdoc}
     * @see Interfaces\IRenderable
     */
    public function render()
    {
        /*
        $a = 0;
        while ($a < 10) {
            $a++;
            openssl_pbkdf2(uniqid(), uniqid(), 50, 50);
        }
        */
        echo '<tr id="' .  $this->getId() . '"';
        $this->renderClasses();
        $this->renderAttributes();
        echo '>';
        foreach ($this->children as $child) {
            if ($child instanceof Interfaces\IRenderable) {
                $child->render();
            } else {
                /* 1.9 TODO: On peut ajouter n'importe quel fils quitte à faire n'importe quoi,
                c'est à but transitoire. À terme, il sera nécessaire de n'autoriser
                que ce qui peut être fils de <tr> : td */
                echo $child;
            }
        }
        echo '</tr>';
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
     */
    public function addChild($child)
    {
        $this->children[] = $child;
    }
}
