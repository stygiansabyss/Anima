<?php

class Forum_PostController extends Core_Forum_PostController {

    protected function submitReply($input, $post)
    {
        $message = e($input['content']);

        if (Input::hasFile('image')) {
            $verify = ForumPost::verifyImage(Input::file('image'));

            if ($verify == false) {
                $this->addError('failedUpload', 'The file you submitted is not an image.');
                return $this->redirect();
            }
        }

        // See who we are posting as
        list($morphType, $morphId) = explode('::', $input['postAs']);

        // We are adding a reply
        $reply                      = new Forum_Reply;
        $reply->forum_post_id       = $post->id;
        $reply->forum_reply_type_id = ($input['forum_reply_type_id'] == 9999 ? Forum_Reply::TYPE_ACTION : $input['forum_reply_type_id']);
        $reply->user_id             = $this->activeUser->id;
        $reply->name                = (isset($input['name']) && $input['name'] != null ? $input['name'] : 'Re: '. $post->name);
        $reply->keyName             = Str::slug($reply->name);
        $reply->content             = $message;
        $reply->quote_id            = (isset($input['quote_id']) && strlen($input['quote_id']) == 10 ? $input['quote_id'] : null);
        $reply->moderatorLockedFlag = 0;
        $reply->adminReviewFlag     = 0;
        $reply->approvedFlag        = ($input['forum_reply_type_id'] == 9999 ? 1 : 0);

        if ($morphType != 'User') {
            $reply->morph_id   = $morphId;
            $reply->morph_type = $morphType;
        } else {
            $reply->morph_id   = null;
            $reply->morph_type = null;
        }

        $this->save($reply);

        $reply->post->modified_at = date('Y-m-d H:i:s');
        $this->checkErrorsSave($reply->post);

        if (Input::hasFile('image')) {
            ForumPost::setPost($reply)->addImage('replies', Input::file('image'));
        }

        // Remove all user views so the post shows as updated
        $post->deleteViews();

        // See if we are updating the status
        if (isset($input['forum_support_status_id']) && $input['forum_support_status_id'] != 0) {
            $status                          = Forum_Post_Status::where('forum_post_id', $post->id)->first();
            $status->forum_support_status_id = $input['forum_support_status_id'];
            $this->save($status);
        }

        return $reply;
    }

    public function postAdd($boardId)
    {
        // Handle any form data
        $input = e_array(Input::all());

        if (Input::hasFile('image')) {
            $verify = ForumPost::verifyImage(Input::file('image'));

            if ($verify == false) {
                $this->addError('failedUpload', 'The file you submitted is not an image.');
                return $this->redirect();
            }
        }

        if ($input != null) {
            $board   = Forum_Board::where('uniqueId', $boardId)->first();
            $message = e($input['content']);

            if (count(Input::file('images')) > 0) {
                $message .= "\n". count(Input::file('images')) .' images attached.';
            }

            // See who we are posting as
            list($morphType, $morphId) = explode('::', $input['postAs']);

            $post                      = new Forum_Post;
            $post->forum_board_id      = $board->id;
            $post->forum_post_type_id  = (isset($input['forum_post_type_id']) && $input['forum_post_type_id'] != 0 ? $input['forum_post_type_id'] : null);
            $post->user_id             = $this->activeUser->id;

            if ($morphType != 'User') {
                $post->morph_id   = $morphId;
                $post->morph_type = $morphType;
            } else {
                $post->morph_id   = null;
                $post->morph_type = null;
            }

            $post->name                = $input['name'];
            $post->keyName             = Str::slug($input['name']);
            $post->content             = $message;
            $post->moderatorLockedFlag = 0;
            $post->approvedFlag        = 0;
            $post->modified_at         = date('Y-m-d H:i:s');

            $this->checkErrorsSave($post);

            if (Input::hasFile('image') && $verify == true) {
                ForumPost::setPost($post)->addImage('posts', Input::file('image'));
            }

            // Set status if a support post
            if ($post->board->category->forum_category_type_id == Forum_Category::TYPE_SUPPORT) {
                $post->setStatus(Forum_Support_Status::TYPE_OPEN);
            }

            // Set this user as already having viewed the post
            $post->userViewed($this->activeUser->id);

            return $this->redirect('forum/post/view/'. $post->id, $post->name.' has been submitted.');
        }
    }

    public function postEdit($type, $resourceId)
    {
        // Handle any form data
        $input = e_array(Input::all());

        if ($input != null) {
            // See who we are posting as
            if (Input::has('postAs')) {
                list($morphType, $morphId) = explode('::', $input['postAs']);
            } else {
                $morphType = 'User';
            }

            // Get the information
            switch ($type) {
                case 'post':
                    $post                     = Forum_Post::find($resourceId);
                    $post->forum_post_type_id = (isset($input['forum_post_type_id']) && $input['forum_post_type_id'] != 0 ? $input['forum_post_type_id'] : null);
                    $post->name               = $input['name'];
                    $post->keyName            = Str::slug($input['name']);
                    $post->content            = e($input['content']);

                    if ($morphType != 'User') {
                        $post->morph_id   = $morphId;
                        $post->morph_type = $morphType;
                    } else {
                        $post->morph_id   = $post->morph_id;
                        $post->morph_type = $post->morph_type;
                    }

                    $this->checkErrorsSave($post);

                    // Add the edit history
                    $reason = (isset($input['reason']) && $input['reason'] != null ? $input['reason'] : null);
                    $post->addEdit($reason);

                    return $this->redirect('forum/post/view/'. $post->uniqueId, $post->name.' has been updated.');

                break;
                case 'reply':
                    $reply                      = Forum_Reply::find($resourceId);
                    $reply->forum_reply_type_id = (isset($input['forum_reply_type_id']) && $input['forum_reply_type_id'] != 0 ? $input['forum_reply_type_id'] : $reply->forum_reply_type_id);
                    $reply->name                = $input['name'];
                    $reply->keyName             = Str::slug($input['name']);
                    $reply->content             = e($input['content']);

                    if ($morphType != 'User') {
                        $reply->morph_id   = $morphId;
                        $reply->morph_type = $morphType;
                    } else {
                        $reply->morph_id   = $reply->morph_id;
                        $reply->morph_type = $reply->morph_type;
                    }

                    $this->checkErrorsSave($reply);

                    // Add the edit history
                    $reason = (isset($input['reason']) && $input['reason'] != null ? $input['reason'] : null);
                    $reply->addEdit($reason);

                    return $this->redirect('forum/post/view/'. $reply->post->uniqueId .'#reply:'. $reply->id, $reply->name.' has been updated.');

                break;
            }
        }
    }

}