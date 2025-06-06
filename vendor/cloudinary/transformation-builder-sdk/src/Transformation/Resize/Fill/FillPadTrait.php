<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Transformation;

use Cloudinary\Transformation\Argument\ColorValue;

/**
 * Trait FillPadTrait
 *
 * @api
 */
trait FillPadTrait
{
    /**
     * Tries to prevent a "bad crop" by first attempting to use the fill mode, but adding padding if it is determined
     * that more of the original image needs to be included in the final image.
     *
     * Especially useful if the aspect ratio of the delivered image is considerably different from the original's
     * aspect ratio.
     *
     * Only supported in conjunction with Automatic cropping (Gravity::auto())
     *
     * @param float|int|string|null    $width      The required width of a transformed asset.
     * @param float|int|null           $height     The required height of a transformed asset.
     * @param string|FocalGravity|null $gravity    Specifies which part of the original image to include.
     * @param string|ColorValue|null   $background The background color of the image.
     *
     *
     * @see Gravity::auto
     */
    public static function fillPad(
        float|int|string|null $width = null,
        float|int|null $height = null,
        string|FocalGravity|null $gravity = null,
        ColorValue|string|null $background = null
    ): FillPad {
        return new FillPad(CropMode::FILL_PAD, $width, $height, $gravity, $background);
    }
}
