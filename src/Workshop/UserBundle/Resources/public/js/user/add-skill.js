var User = {
    skills_count: 0,
    addSkill: function (  ) {
        var skill_field_prototype = $('#skills-list').data('prototype');
        var new_skill_field = skill_field_prototype.replace(/skill_number/g, User.skills_count++);

        $('#skills-list').append($('<li>' + new_skill_field + '</li>'));
    }
};

$('#add-skill').on('click', function(event) {
    event.preventDefault();
    User.addSkill();
});
