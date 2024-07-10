<div class="card p-2 mt-2" data-comment-id="{$comment->getId()}">
    <div class="d-flex justify-content-between align-items-start">
        <div class="user d-flex flex-column">
            <span>
                <small class="fw-bold text-primary">{$comment->getCommentUsername()}</small>
            </span>
            <span class="comment-text">
                <small class="fw-bold">{$comment->getCommentText()}</small>
            </span>
            <small class="ml-auto">{$comment->getTimetoStr()}</small>
        </div>
        <div class="reply px-0">
            <a href="#" class="btn btn-outline-success reply">Reply</a>
        </div>
    </div>
    <div class="replyFormContainer" style="display: none; margin-top: 10px;">
        <form id="replyForm" class="comment-form">
            <div class="form-group">
                <textarea class="form-control" style="resize: none;" name="body" rows="3" required></textarea>
            </div>
            <button type="button" class="btn btn-outline-success mt-2">Post Reply</button>
        </form>
    </div>
</div>
{if $replies|@count > 0}
    <div class="replies ml-4 mt-2">
        {foreach from=$replies item=reply}
            {include file='Smarty/templates/comment.tpl' comment=$reply.comment replies=$reply.replies}
        {/foreach}
    </div>
{/if}
