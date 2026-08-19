-- ============================================
-- SYNCHRONIZATION OF USER'S PERMISSIONS
-- ============================================
DELIMITER $$

-- TRIGGER 1: AFTER INSERT on user_roles
CREATE TRIGGER trg_user_roles_insert
AFTER INSERT ON user_roles
FOR EACH ROW
BEGIN
    -- Insert all permissions from the role into user_permissions
    INSERT IGNORE INTO user_permissions (user_id, permission_id)
    SELECT 
        NEW.user_id,
        rp.permission_id
    FROM role_permissions rp
    WHERE rp.role_id = NEW.role_id;
END$$

-- TRIGGER 2: AFTER DELETE on user_roles
CREATE TRIGGER trg_user_roles_delete
AFTER DELETE ON user_roles
FOR EACH ROW
BEGIN
    -- Remove permissions that came only from this deleted role
    DELETE FROM user_permissions
    WHERE user_id = OLD.user_id
      AND permission_id IN (
          SELECT permission_id FROM role_permissions 
          WHERE role_id = OLD.role_id
      )
      -- Only delete if no other active role assignment gives this permission
      AND NOT EXISTS (
          SELECT 1 
          FROM user_roles ur2
          JOIN role_permissions rp2 ON ur2.role_id = rp2.role_id
          WHERE ur2.user_id = OLD.user_id
            AND ur2.role_id != OLD.role_id
            AND rp2.permission_id = user_permissions.permission_id
      )
      -- And no direct assignment exists
      AND NOT EXISTS (
          SELECT 1 
          FROM user_permissions up2
          WHERE up2.user_id = OLD.user_id
            AND up2.permission_id = user_permissions.permission_id
            AND up2.user_permission_id != user_permissions.user_permission_id
      );
END$$

-- TRIGGER 3: AFTER INSERT on role_permissions
CREATE TRIGGER trg_role_permissions_insert
AFTER INSERT ON role_permissions
FOR EACH ROW
BEGIN
    -- Add this permission to all users who have this role
    INSERT IGNORE INTO user_permissions (user_id, permission_id)
    SELECT 
        ur.user_id,
        NEW.permission_id
    FROM user_roles ur
    WHERE ur.role_id = NEW.role_id;
END$$

-- TRIGGER 4: AFTER DELETE on role_permissions
CREATE TRIGGER trg_role_permissions_delete
AFTER DELETE ON role_permissions
FOR EACH ROW
BEGIN
    -- Remove this permission from users who had it only through this role
    DELETE FROM user_permissions
    WHERE permission_id = OLD.permission_id
      AND user_id IN (
          SELECT user_id FROM user_roles 
          WHERE role_id = OLD.role_id
      )
      -- Keep if user has this permission from another role
      AND NOT EXISTS (
          SELECT 1 
          FROM user_roles ur2
          JOIN role_permissions rp2 ON ur2.role_id = rp2.role_id
          WHERE ur2.user_id = user_permissions.user_id
            AND rp2.permission_id = OLD.permission_id
            AND rp2.role_id != OLD.role_id
      )
      -- Keep if user has direct assignment
      AND NOT EXISTS (
          SELECT 1 
          FROM user_permissions up2
          WHERE up2.user_id = user_permissions.user_id
            AND up2.permission_id = OLD.permission_id
            AND up2.user_permission_id != user_permissions.user_permission_id
      );
END$$

DELIMITER ;
