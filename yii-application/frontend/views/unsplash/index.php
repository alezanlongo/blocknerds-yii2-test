<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Alert;
use yii\bootstrap4\Html;

$this->title = 'Result';
$this->params['breadcrumbs'][] = ['label' => 'UnSplash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    function myFunction(id) {
        $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/collection/ajax' ?>',
                type: 'post',
                data: {
                    '_csrf-frontend': '<?= Yii::$app->request->getCsrfToken() ?>',
                    'Collection': {
                        title: $("[name='title" + id + "']").val(),
                        image: $("[name='image" + id + "']").val()
                    }
                },
                success: function(data) {
                    console.log(data);
                },
            }).done(function() {
                alert('Image added successfully to your collection!');
            })
            .fail(function() {
                alert("Something went wrong try again later =(.");
            });
    }
</script>

<h1>UnSplash result for: <?= $term ?></h1>

<div class="row">
    <?php
    foreach ($unsplash['results'] as $item) {
    ?>
        <div class="col-md-3">
            <div class="card">
                <img src="<?= $item['urls']["thumb"] ?>" class="card-mg-top" width="100%" />
                <div class="card-body">
                    <h5 class="card-title"><?= $item['description'] ?></h5>
                    <?= Html::hiddenInput('title' . $item['id'], trim($item['description']) == "" ? substr($item['user']['name'], 0, 255) : substr($item['description'], 0, 255)); ?>
                    <?= Html::hiddenInput('image' . $item['id'], substr($item['urls']['small'], 0, 255)); ?>
                    <a href="#" class="card-link" onclick="myFunction('<?= $item['id']; ?>')">Add to collection</a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>