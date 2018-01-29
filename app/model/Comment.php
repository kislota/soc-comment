<?php

namespace app\model;


use core\Model;
use core\lib\Request;

class Comment extends Model
{

    /**
     * @param Request $request
     * @return bool|string
     */
    public function getComments($request = '')
    {
        $limit = 'LIMIT 5';
        if (isset($request->num)) {
            $limit = 'LIMIT ' . $request->num . ', 5';
        } elseif (isset($request->all)) {
            $limit = '';
        }
        $comments = $this->db->findAll('SELECT * FROM comments
                                                WHERE parent_id IS NULL
                                                ORDER BY date DESC ' . $limit);
        if (count($comments) > 0) {
            foreach ($comments as $value) {
                $user = new User;
                $value->user = $user->getUser($value->user_id);
                $this->comments{$value->parent_id}{$value->id} = $value;
                $parent = $this->db->findAll('SELECT * FROM comments 
                                              WHERE parent_id = ' . $value->id . ' 
                                              ORDER BY date');
                $this->parent($parent);
            }
            return $this->viewComments($this->comments, null);
        } else
            return false;
    }

    /**
     * @param $array
     */
    private function parent($array)
    {
        if (is_array($array)) {
            foreach ($array as $value) {
                $user = new User;
                $value->user = $user->getUser($value->user_id);
                $this->comments[$value->parent_id][$value->id] = $value;
                $parent = $this->db->findAll('SELECT * FROM comments 
                                                  WHERE parent_id = ' . $value->id . ' 
                                                  ORDER BY date');
                if (!empty($parent)) {
                    $this->parent($parent);
                }
            }
        }
    }

    /**
     * @param $array
     * @param $parent_id
     * @param bool $parent
     * @return bool|string
     */
    private function viewComments($array, $parent_id)
    {
        if (is_array($array) and isset($array[$parent_id])) {
            $items = '<ul>';
            foreach ($array[$parent_id] as $comment) {
                $items .= "<li><div class='comment'><div class='avatar'><img src="
                    . $comment->user->avatar . "></div><div class='author'>Автор: "
                    . $comment->user->name . "<span class='date'>"
                    . $comment->date . "</span></div><div class='message' id='message-" . $comment->id . "'>"
                    . $comment->message . "</div></div>"
                    . formComment($comment->id, $comment->user_id, $comment->message);
                $items .= $this->viewComments($array, $comment->id);
                $items .= '</li>';
            }
            $items .= '</ul>';
        } else return false;
        return $items;
    }

    /**
     * @param $request
     * @param $userId
     * @return mixed
     */
    public function saveComment($request)
    {
        $commentId = $this->db->insert('INSERT INTO comments (parent_id, user_id, message) VALUE (:parent_id, :user_id, :message)',
            [
                'parent_id' => $request->parent_id,
                'user_id' => $this->id(),
                'message' => htmlspecialchars_decode($request->message)
            ]
        );
        return $commentId;
    }

    public function editComment($request)
    {
        return $this->db->update('UPDATE comments SET message = :message WHERE id = :id',
            [
                'message' => htmlspecialchars_decode($request->message),
                'id' => $request->comment_id
            ]
        );
    }
}