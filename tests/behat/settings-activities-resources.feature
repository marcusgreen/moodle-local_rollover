@local @local_rollover @javascript
Feature: Rules for rolling over activities and resources
  In order to prevent duplication or missing activities in rollover
  As a site administrator
  I want to define a way to enforce activities to be rolled over or blocked from rolling over

  Scenario: I can navigate to it.
    Given I am an administrator                                             # local_rollover
    When I navigate to "Courses > Rollover settings > Activities & Resources" in site administration
    Then I should see "Activities and resources rollover rules"
    And I should see "No rules"

  Scenario: I can view current rules.
    Given I am an administrator                                             # local_rollover
    And the following activity rollover rules exist:                        # local_rollover
      | rule        | activity   | regex             |
      | enforce     | Assignment |                   |
      | forbid      | Forum      | /^Announcements$/ |
      | not default |            | /^.*TEST.*$/      |
    When I go to the "Activities & Resources" settings page                 # local_rollover
    Then I should not see "No rules"
    But I should see "Rule #1: Forbid rolling over any 'Forum' matching: /^Announcements$/"
    And I should see "Rule #2: Enforce rolling over all 'Assignment' activities."
    And I should see "Rule #3: Do not rollover by default any activity matching: /^.*TEST.*$/"

  Scenario: I can add a new rule.
    Given I am an administrator                                            # local_rollover
    And I am at the "Activities & Resources" settings page                 # local_rollover
    When I follow "Add new rule"
    And I set the field "Rule" to "Enforce"
    And I set the field "Activity" to "Quiz"
    And I set the field "Regular Expression" to "/^Final Exam$/"
    And I press "Add rule"
    Then I should see "Rule #1: Enforce rolling over any 'Quiz' matching: /^Final Exam$/"

  Scenario: I can edit an existing rule.
    Given I am an administrator                                            # local_rollover
    And the following activity rollover rules exist:                       # local_rollover
      | rule    | activity   | regex |
      | enforce | Assignment |       |
    And I am at the "Activities & Resources" settings page                 # local_rollover
    When I follow "Change rule"
    And I set the field "Activity" to "Wiki"
    And I set the field "Regular Expression" to "/^All time wiki$/"
    And I press "Update rule"
    Then I should see "Rule #1"
    And I should see "Wiki"
    And I should see "/^All time wiki$/"
    But I should not see "Rule #2"

  Scenario: I can cancel when adding a new rule.
    Given I am an administrator                                            # local_rollover
    And I am at the "Activities & Resources" settings page                 # local_rollover
    When I follow "Add new rule"
    And I press "Cancel"
    Then I should see "No rules"

  Scenario: I can remove an existing rule.
    Given I am an administrator                                            # local_rollover
    And the following activity rollover rules exist:                       # local_rollover
      | rule    | activity   | regex |
      | enforce | Assignment |       |
    And I am at the "Activities & Resources" settings page                 # local_rollover
    When I follow "Remove rule"
    And I press "Remove rule"
    Then I should see "No rules"

  Scenario: I can cancel when adding a new rule.
    Given I am an administrator                                            # local_rollover
    And the following activity rollover rules exist:                       # local_rollover
      | rule    | activity   | regex             |
      | enforce | Assignment | /^My Funny Rule$/ |
    And I am at the "Activities & Resources" settings page                 # local_rollover
    When I follow "Remove rule"
    And I press "Cancel"
    Then I should see "/^My Funny Rule$/"