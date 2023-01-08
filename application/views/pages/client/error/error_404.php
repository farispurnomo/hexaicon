<div class="container">
    <div class="row d-flex align-items-center min-vh-100">
        <div class="col-xl-6 m-auto">
            <div class="error">
                <div class="number">4</div>
                <div class="number d-block d-md-none">0</div>
                <div class="illustration d-none d-md-block">
                    <div class="circle"></div>
                    <div class="clip">
                        <div class="paper">
                            <div class="face">
                                <div class="eyes">
                                    <div class="eye eye-left"></div>
                                    <div class="eye eye-right"></div>
                                </div>
                                <div class="rosyCheeks rosyCheeks-left"></div>
                                <div class="rosyCheeks rosyCheeks-right"></div>
                                <div class="mouth"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="number">4</div>
            </div>

            <div class="text-center">
                <div class="mt-4 mb-2 h3">Oops. The page you're looking for doesn't exist.</div>
                <a href="" class="btn btn-hi-primary"><i class="fa fa-home"></i> Home</a>
            </div>
        </div>
    </div>
</div>

<style>
    center {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .error {
        display: flex;
        flex-direction: row;
        /* justify-content: space-between; */
        /* justify-content: space-evenly; */
        justify-content: center;
        align-content: center;
    }

    .number {
        font-weight: 900;
        /* font-size: 15rem; */
        font-size: calc(7rem + 8vw);
        line-height: 1;
    }

    .illustration {
        position: relative;
        width: 12.2rem;
        margin: 0 2.1rem;
    }

    .circle {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 12.2rem;
        height: 11.4rem;
        border-radius: 50%;
        /* background-color: #293b49; */
        background: linear-gradient(to right, #DF5933, #d44551);
    }

    .clip {
        position: absolute;
        bottom: 0.3rem;
        left: 50%;
        transform: translateX(-50%);
        overflow: hidden;
        width: 12.5rem;
        height: 13rem;
        border-radius: 0 0 50% 50%;
    }

    .paper {
        position: absolute;
        bottom: -0.3rem;
        left: 50%;
        transform: translateX(-50%);
        width: 9.2rem;
        height: 12.4rem;
        /* border: 0.3rem solid #293b49; */
        border: 0.3rem solid var(--hi-purple);
        background-color: white;
        border-radius: 0.8rem;
    }

    .paper::before {
        content: "";
        position: absolute;
        top: -0.7rem;
        right: -0.7rem;
        width: 1.4rem;
        height: 1rem;
        background-color: white;
        /* border-bottom: 0.3rem solid #293b49; */
        border-bottom: 0.3rem solid var(--hi-purple);
        transform: rotate(45deg);
    }

    .face {
        position: relative;
        margin-top: 2.3rem;
    }

    .eyes {
        position: absolute;
        top: 0;
        left: 2.4rem;
        width: 4.6rem;
        height: 0.8rem;
    }

    .eye {
        position: absolute;
        bottom: 0;
        width: 0.8rem;
        height: 0.8rem;
        border-radius: 50%;
        background-color: #293b49;
        animation-name: eye;
        animation-duration: 4s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
    }

    .eye-left {
        left: 0;
    }

    .eye-right {
        right: 0;
    }

    @keyframes eye {
        0% {
            height: 0.8rem;
        }

        50% {
            height: 0.8rem;
        }

        52% {
            height: 0.1rem;
        }

        54% {
            height: 0.8rem;
        }

        100% {
            height: 0.8rem;
        }
    }

    .rosyCheeks {
        position: absolute;
        top: 1.6rem;
        width: 1rem;
        height: 0.2rem;
        border-radius: 50%;
        background-color: #fdabaf;
    }

    .rosyCheeks-left {
        left: 1.4rem;
    }

    .rosyCheeks-right {
        right: 1.4rem;
    }

    .mouth {
        position: absolute;
        top: 3.1rem;
        left: 50%;
        width: 1.6rem;
        height: 0.2rem;
        border-radius: 0.1rem;
        transform: translateX(-50%);
        background-color: #293b49;
    }

    .button {
        margin-top: 4rem;
        padding: 1.2rem 3rem;
        color: white;
        background-color: #04cba0;
    }

    .button:hover {
        background-color: #01ac88;
    }
</style>