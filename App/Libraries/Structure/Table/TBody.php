<?php
namespace App\Libraries\Structure\Table;

use App\Libraries\Interfaces;
use App\Libraries\Structure\AHtmlElement;

/**
 * Groupe tbody d'une table html
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \Tests\Units\App\Libraries\Structure\Table\Thead
 */
class TBody extends AHtmlElement implements Interfaces\IHeritable
{
    /**
     * Liste d'enfants de la section
     *
     * @var array
     */
    private $children = [];

    /**
     * {@inheritdoc}
     * @see Interfaces\IRenderable
     */
    public function render()
    {
        echo '<tbody id="' .  $this->getId() . '"';
        $this->renderClasses();
        $this->renderAttributes();
        echo '>';
        foreach ($this->children as $child) {
            if ($child instanceof Interfaces\IRenderable) {
                $child->render();
            } else {
                /* 1.9 TODO: On peut ajouter n'importe quel fils quitte à faire n'importe quoi,
                c'est à but transitoire. À terme, il sera nécessaire de n'autoriser
                que ce qui peut être fils de <tbody> : tr */
                echo $child;
            }
        }
        echo '</tbody>';
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
