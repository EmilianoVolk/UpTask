<?php include_once __DIR__ . '/header-dashboard.php' ?>

<?php if (count($projects) === 0) { ?>
    <a class="no-projects">No Projects yet, <a href="/create-project">Click Here to Create a Project</a></p>
    <?php } else { ?>
        <ul class="projects-list">
            <?php foreach ($projects as $project) { ?>
                <li>
                    <a href="/project?id=<?php echo $project->url ?>" class="project"><?php echo $project->project ?></a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>