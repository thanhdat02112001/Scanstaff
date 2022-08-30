import React from 'react';
import styles from "./UserWrapper.module.css"

const UserWrapper = (props) => {
    return (
        <div className={styles['interviewer-wrapper']}>
            {props.children}
        </div>
    );
}
export default UserWrapper;
