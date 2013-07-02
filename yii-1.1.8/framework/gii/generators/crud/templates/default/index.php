<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->addBreadcrumbs(array(
	'$label',
));\n";
?>

$this->viewMenu=array(
	array('label'=>'Manage <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
);

$this->editMenu=array(
	array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
);
?>

<h1><?php echo $label; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
