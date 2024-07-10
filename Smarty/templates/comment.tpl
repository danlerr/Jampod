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
        <div class="reply d-flex flex-column px-0">
            <div class="mb-2 d-flex justify-content-center align-items-center">
                <a href="#" class="link-secondary svg-trigger">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>

                </a>
                                                
            </div>
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
