<form action="<?= \yii\helpers\Url::to(['instructor/give-grade']) ?>" method="post">
    <input type="hidden" name="_csrf-frontend" value="">
    <?php foreach ($gradingData as $data){ ?>
        <div>
            <label><?= $data['studentName'] ?></label>
            <div>
                grade :<?= $data['grade'] ?>
            </div>
            <div>
                <input name="takes[<?= $data['takeId'] ?>]" value="<?=$data['grade'] ?>">
            </div>
        </div>

    <?php } ?>
    <input type="submit" value="save grades" class="btn btn-success" style="margin-top: 20px">
</form>