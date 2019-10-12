<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld;


use Illuminate\Database\Eloquent\Model;

/**
 * LaravelFranceOld\ForumsCategory
 *
 * @property integer $id
 * @property integer $order
 * @property string $name
 * @property string $slug
 * @property string $background_color
 * @property string $font_color
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereBackgroundColor($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereFontColor($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFranceOld\ForumsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ForumsCategory extends Model
{

}
