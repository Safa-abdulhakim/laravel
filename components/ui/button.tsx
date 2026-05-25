import * as React from "react";
import { Slot } from "@radix-ui/react-slot";
import { cva, type VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

const buttonVariants = cva(
  "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl text-sm font-semibold ring-offset-background transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0",
  {
    variants: {
      variant: {
        default:
          "bg-navy-600 text-white hover:bg-navy-700 shadow-navy hover:shadow-navy-lg active:scale-[0.98]",
        primary:
          "bg-gradient-to-l from-navy-600 to-violet-600 text-white hover:from-navy-700 hover:to-violet-700 shadow-glass hover:shadow-glow active:scale-[0.98]",
        secondary:
          "bg-violet-500 text-white hover:bg-violet-600 shadow-glow hover:shadow-glow-lg active:scale-[0.98]",
        outline:
          "border-2 border-navy-600 text-navy-600 hover:bg-navy-600 hover:text-white dark:border-navy-300 dark:text-navy-300 dark:hover:bg-navy-700 dark:hover:text-white active:scale-[0.98]",
        ghost:
          "text-foreground hover:bg-muted hover:text-foreground active:scale-[0.98]",
        glass:
          "bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 active:scale-[0.98]",
        destructive:
          "bg-destructive text-destructive-foreground hover:bg-destructive/90 active:scale-[0.98]",
        link: "text-violet-500 underline-offset-4 hover:underline p-0 h-auto",
      },
      size: {
        default: "h-10 px-5 py-2",
        sm: "h-8 rounded-lg px-3 text-xs",
        lg: "h-12 rounded-xl px-8 text-base",
        xl: "h-14 rounded-2xl px-10 text-lg",
        icon: "h-10 w-10",
        "icon-sm": "h-8 w-8 rounded-lg",
        "icon-lg": "h-12 w-12 rounded-xl",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  }
);

export interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {
  asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant, size, asChild = false, ...props }, ref) => {
    const Comp = asChild ? Slot : "button";
    return (
      <Comp
        className={cn(buttonVariants({ variant, size, className }))}
        ref={ref}
        {...props}
      />
    );
  }
);
Button.displayName = "Button";

export { Button, buttonVariants };
