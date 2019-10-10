<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;

/**
 * LaravelFrance\ForumsCategory
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
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereBackgroundColor($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereFontColor($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\ForumsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ForumsCategory extends Model
{

}