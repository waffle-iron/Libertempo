<?php
namespace Tests\Units\App\Libraries\Structure\Table;

use Tests\Units\TestUnit;
use \App\Libraries\Structure\Table\Thead as _Thead;


/**
 * Classe de test du groupe thead d'une table html
 *
 * @since  1.9
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @see    \App\Libraries\Structure\Table\Thead
 */
class Thead extends TestUnit
{
    /**
     * Test du render d'un thead avec un fils non renderable
     *
     * @return void
     * @since 1.9
     */
    public function testRenderWithoutRenderable()
    {
        $thead = new _Thead();
        $thead->addChild('Child');

        $this->output(function () use ($thead) {
            $thead->render();
        })->contains('Child');
    }

    /**
     * Test du render d'un thead avec un fils renderable
     *
     * @return void
     * @since 1.9
     */
    public function testRenderWithRenderable()
    {
        $thead = new _Thead();
        $child = new \Mock\App\Libraries\Structure\Table\Thead();
        $thead->addChild($child);

        $this->output(function () use ($thead, $child) {
            $this->when($thead->render())
                ->mock($child)
                    ->call('render')
                        ->once();
        });
    }

    /**
     * Test d'ajouts multiples d'enfants
     *
     * @return void
     * @since 1.9
     */
    public function testAddChildren()
    {
        $thead = new \Mock\App\Libraries\Structure\Table\Thead();
        $child = 'child';

        $this->when($thead->addChildren([$child]))
            ->mock($thead)
                ->call('addChild')
                    ->once();
    }
}
