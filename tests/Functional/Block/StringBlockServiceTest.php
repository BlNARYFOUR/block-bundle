<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\BlockBundle\Tests\Functional\Block;

use Sonata\BlockBundle\Block\BlockContext;
use Symfony\Cmf\Bundle\BlockBundle\Block\StringBlockService;
use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\StringBlock;
use Twig\Environment;

class StringBlockServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testExecutionOfEnabledBlock()
    {
        $template = '@CmfBlock/Block/block_string.html.twig';
        $stringBlock = new StringBlock();
        $stringBlock->setEnabled(true);
        $blockContext = new BlockContext($stringBlock, ['template' => $template]);

        $templatingMock = $this->createMock(Environment::class);
        $templatingMock->expects($this->once())
            ->method('renderResponse')
            ->with(
                $this->equalTo($template),
                $this->equalTo([
                    'block' => $stringBlock,
                ])
            );

        $stringBlockService = new StringBlockService('test-service', $templatingMock, $template);
        $stringBlockService->execute($blockContext);
    }

    public function testExecutionOfDisabledBlock()
    {
        $stringBlock = new StringBlock();
        $stringBlock->setEnabled(false);

        $templatingMock = $this->createMock(Environment::class);
        $templatingMock->expects($this->never())
             ->method('renderResponse');

        $stringBlockService = new StringBlockService('test-service', $templatingMock);
        $stringBlockService->execute(new BlockContext($stringBlock));
    }
}
