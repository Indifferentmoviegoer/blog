<?php

namespace common\widgets;

use common\repositories\CommentRepository;
use yii\base\Widget;
use common\models\Comment;

/**
 * Class CommentWidget
 * @package common\widgets
 */
class CommentWidget extends Widget
{
    public int $id;
    public int $type;

    /**
     *{@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $model = new Comment();
        $commentRepository = new CommentRepository();

        if ($this->type == 1) {
            $comments = $commentRepository->getLastNewsComments($this->id);
        } elseif ($this->type == 2) {
            $comments = $commentRepository->getLastGalleryComments($this->id);
        }

        return $this->render(
            'comments',
            [
                'comments' => $comments,
                'model' => $model,
                'id' => $this->id,
                'type' => $this->type
            ]
        );
    }
}
