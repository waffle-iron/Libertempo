<?php
namespace Tests\Units\App\Libraries\Structure;

use \App\Libraries\Structure\Table as _Table;

/**
 * Classe de tests des tables html
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \App\Libraries\Structure\Table
 */
class Table extends \Tests\Units\TestUnit
{
    /**
     * Test du render d'une table avec un fils non renderable
     *
     * @return void
     * @since 1.9
     */
    public function testRenderWithoutRenderable()
    {
        $table = new _Table();
        $table->addChild('Child');

        $this->output(function () use ($table) {
            $table->render();
        })->contains('Child');
    }

    /**
     * Test du render d'une table avec un fils renderable
     *
     * @return void
     * @since 1.9
     */
    public function testRenderWithChildRenderable()
    {
        $table = new _Table();
        $child = new \Mock\App\Libraries\Structure\Table();
        $table->addChild($child);

        $this->output(function () use ($table, $child) {
            $this->when($table->render())
                ->mock($child)
                    ->call('render')
                        ->once();
        });
    }

    /**
     * Test du render d'une table avec un thead
     *
     * @return void
     * @since 1.9
     */
    public function testRenderWithThead()
    {
        $table = new _Table();
        $thead = new \Mock\App\Libraries\Structure\Table\Thead();
        $table->addChild($thead);

        $this->output(function () use ($table, $thead) {
            $this->when($table->render())
                ->mock($thead)
                    ->call('render')
                        ->once();
        });
    }

    /**
     * Test de l'ajout de deux thead
     *
     * @return void
     * @since 1.9
     */
    public function testAddTwoThead()
    {
        $table  = new _Table();
        $thead1 = new \Mock\App\Libraries\Structure\Table\Thead();
        $thead2 = new \Mock\App\Libraries\Structure\Table\Thead();
        $table->addChild($thead1);

        $this->exception(function () use ($table, $thead2) {
            $table->addChild($thead2);
        })->isInstanceOf('\LogicException');
    }

    /**
     * Test d'ajouts multiples d'enfants
     *
     * @return void
     * @since 1.9
     */
    public function testAddChildren()
    {
        $table = new \Mock\App\Libraries\Structure\Table();
        $child = 'child';

        $this->when($table->addChildren([$child]))
            ->mock($table)
                ->call('addChild')
                    ->once();
    }
}
