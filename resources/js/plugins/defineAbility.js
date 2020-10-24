const { defineAbility } = require('@casl/ability');

module.exports = defineAbility((can, cannot) => {
  can('manage', 'all');
  cannot('delete', 'User');
});  
/* 
import { defineAbility } from '@casl/ability';

export default function defineAbilityFor(user) {
  return defineAbility((can) => {
    can('read', 'Article');

    if (user.isLoggedIn) {
      can('update', 'Article', { authorId: user.id });
      can('leave', 'Comment');
      can('update', 'Comment', { authorId: user.id });
    }
  });
} */