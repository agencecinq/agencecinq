import { Piece } from "piecesjs";
import A from "@19h47/accordion";
import gsap from "gsap";

class AccordionGroup extends Piece {
    private accordion: A;

    constructor() {
        super("AccordionGroup");
    }

    mount() {
        const enableOn = this.getAttribute("data-accordion-enable-on"); // Get the data attribute
        const enable = enableOn ? enableOn.split(",").map((s) => s.trim()) : []; // Array of enabled modes
        const mm = gsap.matchMedia();

        this.accordion = new A(this);

        if (!enable.length) {
            return this.accordion.init();
        }

        mm.add(
            {
                desktop: "(min-width: 1024px)",
                mobile: "(max-width: 1023px)",
            },
            (context) => {
                // @ts-ignore
                const { desktop, mobile } = context.conditions;

                if (enable.includes("mobile") && mobile) {
                    this.accordion.init();

                    this.accordion.panels.forEach((panel) => {
                        panel.$button.removeAttribute("tabindex");
                    });
                } else if (enable.includes("desktop") && desktop) {
                    this.accordion.init();

                    this.accordion.panels.forEach((panel) => {
                        panel.$button.removeAttribute("tabindex");
                    });
                } else {
                    // Exclude buttons from keyboard navigation on desktop
                    this.accordion.panels.forEach((panel) => {
                        panel.$button.setAttribute("tabindex", "-1");
                    });

                    this.accordion.destroyAll();

                }
            },
        );
    }

    unmount() {
        this.accordion.destroyAll();
    }
}

customElements.define("cinq-accordion-group", AccordionGroup);