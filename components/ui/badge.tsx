import * as React from "react";
import { cva, type VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

const badgeVariants = cva(
  "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-primary text-primary-foreground hover:bg-primary/80",
        secondary:
          "border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80",
        outline: "text-foreground border-border",
        destructive:
          "border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80",
        depression:
          "border-depression-medium bg-depression-light text-depression-text dark:bg-depression/10 dark:text-depression dark:border-depression/30",
        anxiety:
          "border-anxiety-medium bg-anxiety-light text-anxiety-text dark:bg-anxiety/10 dark:text-anxiety dark:border-anxiety/30",
        stress:
          "border-stress-medium bg-stress-light text-stress-text dark:bg-stress/10 dark:text-stress dark:border-stress/30",
        violet:
          "border-violet-200 bg-violet-50 text-violet-700 dark:bg-violet-900/20 dark:text-violet-300 dark:border-violet-700/40",
        navy:
          "border-navy-200 bg-navy-50 text-navy-700 dark:bg-navy-900/30 dark:text-navy-300 dark:border-navy-700/40",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
);

export interface BadgeProps
  extends React.HTMLAttributes<HTMLDivElement>,
    VariantProps<typeof badgeVariants> {}

function Badge({ className, variant, ...props }: BadgeProps) {
  return (
    <div className={cn(badgeVariants({ variant }), className)} {...props} />
  );
}

export { Badge, badgeVariants };
