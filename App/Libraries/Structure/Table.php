<?php
namespace App\Libraries\Structure;

use \App\Libraries\Interfaces;
use \App\Libraries\Structure\Table\Thead;

/**
 * Table html
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \Tests\Units\App\Libraries\Structure\Table
 */
class Table extends AHtmlElement implements Interfaces\IHeritable
{
    /**
     * Liste d'enfants de la table
     *
     * @var array
     * @TODO : à virer dès qu'il n'y a plus autre chose que thead, tfoot, tbody et tr d'injecté
     * autrement dit quand addChild ne fera plus de $this->children[] = $var
     */
    private $children = [];

    /**
     * Section thead du tableau
     *
     * @var Thead
     */
    private $thead;

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
        if ($this->thead instanceof Interfaces\IRenderable) {
            $this->thead->render();
        }
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
     */
    public function addChild($child)
    {
        if ($child instanceof Thead) {
            $this->setHead($child);
        } else {
            $this->children[] = $child;
        }

    }

    /**
     * Définit le groupement thead de la table
     *
     * @param Thead $thead
     *
     * @return void
     * @throws \LogicException si l'on ajoute plus d'un thead
     */
    private function setHead(Thead $thead)
    {
        if (!empty($this->thead)) {
            throw new \LogicException('Un thead maximum');
        }
        $this->thead = $thead;
    }

/*
 * TODO: Avoir un collecteur tr, et on render les tr directement s'il n'y a pas thead, tbody, tfoot...
 */
}
