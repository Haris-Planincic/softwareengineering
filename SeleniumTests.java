
// Required dependencies: Selenium WebDriver and ChromeDriver

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class SeleniumTests {
    public static void main(String[] args) throws InterruptedException {
        System.setProperty("webdriver.chrome.driver", "path_to_chromedriver");

        // Run tests
        testRegistration();
        testLogin();
        testContactForm();
    }

    public static void testRegistration() throws InterruptedException {
        WebDriver driver = new ChromeDriver();
        driver.get("http://localhost/seproject/frontend/register.html");

        driver.findElement(By.id("firstName")).sendKeys("Test");
        driver.findElement(By.id("lastName")).sendKeys("User");
        driver.findElement(By.id("email")).sendKeys("testuser@example.com");
        driver.findElement(By.id("password")).sendKeys("TestPassword123");
        driver.findElement(By.id("phone")).sendKeys("1234567890");
        driver.findElement(By.id("registerBtn")).click();

        Thread.sleep(2000); // wait for response
        if (driver.getPageSource().toLowerCase().contains("success")) {
            System.out.println("Registration Test Passed");
        } else {
            System.out.println("Registration Test Failed");
        }

        driver.quit();
    }

    public static void testLogin() throws InterruptedException {
        WebDriver driver = new ChromeDriver();
        driver.get("http://localhost/seproject/frontend/login.html");

        driver.findElement(By.id("email")).sendKeys("testuser@example.com");
        driver.findElement(By.id("password")).sendKeys("TestPassword123");
        driver.findElement(By.id("loginBtn")).click();

        Thread.sleep(2000);
        if (driver.getCurrentUrl().toLowerCase().contains("index") || driver.getPageSource().toLowerCase().contains("welcome")) {
            System.out.println("Login Test Passed");
        } else {
            System.out.println("Login Test Failed");
        }

        driver.quit();
    }

    public static void testContactForm() throws InterruptedException {
        WebDriver driver = new ChromeDriver();
        driver.get("http://localhost/seproject/frontend/contact.html");

        driver.findElement(By.id("firstName")).sendKeys("Test");
        driver.findElement(By.id("lastName")).sendKeys("User");
        driver.findElement(By.id("email")).sendKeys("contactuser@example.com");
        driver.findElement(By.id("message")).sendKeys("This is a test contact message.");
        driver.findElement(By.id("submitBtn")).click();

        Thread.sleep(2000);
        if (driver.getPageSource().toLowerCase().contains("message sent") || driver.getPageSource().toLowerCase().contains("thank you")) {
            System.out.println("Contact Form Test Passed");
        } else {
            System.out.println("Contact Form Test Failed");
        }

        driver.quit();
    }
}
