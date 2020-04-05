<?php require_once APPROOT . '/views/inc/header.php' ?>
<div class="row">
    <div class="col s12">
        <div class="card card-body bg-light center">
            <!-- <?php //flash('register_success'); 
                    ?> -->
            <h2>Calendar Settings</h2>
            <!-- <p>Please fill in your credentials to log in</p> -->
            <form action="<?php echo URLROOT; ?>/calendarConfigs/makeUserSettings" method="post">
                <div class="form-group">
                    <label for="language">Language:</label>
                    <div class="input-field col s12">
                        <select name="language">
                            <option value="<?php echo $data['languageId']; ?>" selected><?php echo $data['language']; ?></option>
                            <?php foreach ($data['allLanguages'] as $lang) : ?>
                                <option value="<?php echo $lang->id; ?>"><?php echo $lang->title; ?></option>
                                <?php if ($lang->id != $data['languageId']) : ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <p>
                            <label>
                                <?php if (isset($data['usingThemes']) && $data['usingThemes'] == 1) : ?>
                                    <input name="usingThemes" type="checkbox" checked />
                                <?php else : ?>
                                    <input name="usingThemes" type="checkbox" />
                                <?php endif; ?>
                                <span>Use Themes</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <?php if (isset($data['notifications']) && $data['notifications'] == 1) : ?>
                                    <input name="notifications" type="checkbox" checked />
                                <?php else : ?>
                                    <input name="notifications" type="checkbox" />
                                <?php endif; ?>
                                <span>Notifications</span>
                            </label>
                        </p>
                    </div><br />

                    <input type="submit" value="Save Changes" class="btn btn-success" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php' ?>