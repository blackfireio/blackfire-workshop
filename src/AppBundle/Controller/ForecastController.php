<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller used to get the forecast informations.
 *
 *
 * @author Tugdual Saunier <tucksaun@gmail.com>
 */
class ForecastController extends Controller
{
    public function infoAction()
    {
        return $this->render(
            'forecast/info.html.twig',
            array(
                'forecast' => $this->get('app.forecast')->fetch(),
            )
        );
    }
}
