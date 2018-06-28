import React from 'react';

import Wrapper from '../../hoc/Wrapper';

const layout = (props) => (
    <Wrapper>
    <header>
        <h1>Logo: Twilight Imperium HUD</h1>
        <span>Game Code:</span>
    </header>
    <main>{props.children}</main>
    </Wrapper>
);

export default layout;