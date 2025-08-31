<div class="card-grid">
    <div class="card">
        <h2>About Kawakawa Inc.</h2>
        <p><?php echo $org_info['description']; ?></p>
        <p>We're a tight-knit community of traders, manufacturers, and logistics specialists working together to build a prosperous future in the universe. Whether you're a veteran spacefarer or just starting your journey among the stars, we welcome you with open arms.</p>
        
        <h3>Join Our Community</h3>
        <ul>
            <?php foreach ($org_info['links'] as $link): ?>
                <li><a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['title']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="card">
        <h2>About Prosperous Universe</h2>
        <p>Prosperous Universe is a real-time economic space simulation MMO where players build and manage interstellar corporations. Set in a persistent universe, the game focuses on realistic economic gameplay including:</p>
        <ul>
            <li>Complex supply chain management</li>
            <li>Resource extraction and manufacturing</li>
            <li>Trade route optimization</li>
            <li>Corporate governance and collaboration</li>
            <li>Planetary base construction</li>
        </ul>
        <p>Unlike traditional space games focused on combat, Prosperous Universe emphasizes economic strategy, logistics, and player cooperation to build thriving interstellar businesses.</p>
        <p><a href="https://prosperousuniverse.com" target="_blank">Join Prosperous Universe →</a></p>
    </div>
</div>

<?php if (!empty($related_orgs)): ?>
<div class="card-grid">
    <div class="card">
        <h2>Related Organizations</h2>
        <?php foreach ($related_orgs as $org): ?>
            <div style="margin-bottom: 1.5rem;">
                <h3><?php echo htmlspecialchars($org['name']); ?></h3>
                <p><?php echo htmlspecialchars($org['description']); ?></p>
                <?php if (!empty($org['links'])): ?>
                    <p>
                        <?php foreach ($org['links'] as $link): ?>
                            <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['title']); ?></a>
                            <?php if ($link !== end($org['links'])): ?> | <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="card-grid">
    <div class="card">
        <h2>Tools We Use</h2>
        <?php foreach ($tools as $tool): ?>
            <div style="margin-bottom: 1rem;">
                <h3><a href="<?php echo htmlspecialchars($tool['url']); ?>" target="_blank"><?php echo htmlspecialchars($tool['title']); ?></a></h3>
                <p><?php echo htmlspecialchars($tool['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="card-grid">
    <div class="card">
        <h2>Credits</h2>
        <?php foreach ($credits as $credit): ?>
            <div style="margin-bottom: 1rem;">
                <strong><?php echo htmlspecialchars($credit['user']); ?></strong>
                <p><?php echo htmlspecialchars($credit['contribution']); ?></p>
                <?php if (!empty($credit['links'])): ?>
                    <p>
                        <?php foreach ($credit['links'] as $link): ?>
                            <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['title']); ?></a>
                            <?php if ($link !== end($credit['links'])): ?> | <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card">
        <h2>Open Source</h2>
        <p>We believe in transparency and community contribution. Our tools and resources are open source:</p>
        <?php foreach ($open_source as $project): ?>
            <div style="margin-bottom: 1rem;">
                <h3><a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank"><?php echo htmlspecialchars($project['title']); ?></a></h3>
                <p><?php echo htmlspecialchars($project['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>