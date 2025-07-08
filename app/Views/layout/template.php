<?= $this->include('layout/initialisation') ?>
<main>
	<!--start the project-->
	<div id="main-wrapper" class="flex p-5 xl:pr-0">
		<?= $this->include('layout/sidebar') ?>
		<div class=" w-full page-wrapper xl:px-6 px-0">
			<main class="h-full max-w-full">
				<div class="container full-container p-0 flex flex-col gap-6">
					<?= $this->include('layout/header') ?>
					<?= $this->renderSection('content') ?>
				</div>
			</main>
		</div>
	</div>
	<!--end of project-->
</main>
<?= $this->include('components/toasts') ?>
<?= $this->include('layout/footer') ?>