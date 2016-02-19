package com.startuppuccino.account;

import javax.validation.Valid;

import java.security.Principal;

import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotBlank;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.security.access.annotation.Secured;
import org.springframework.stereotype.Controller;
import org.springframework.util.Assert;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.PathVariable;



@Controller
public class AccountController
{
    //@Autowired
    private final AccountRepository accountRepository;


    private final String hello = new String("dasdasdasasdsd");
//    @Autowired
    private final AccountService accountService_;
    private final AccountService accountService2;

//    @RequestMapping(value = "/login", method = RequestMethod.GET)
//    public String login()
//    {
//        return "account/login";
//    }



    @Autowired
    public AccountController(AccountRepository accountRepository, AccountService accountService)
    {
        if (accountService == null)
            throw new RuntimeException("rrrrrrrr");

        System.err.println(this + "CREATED, " + accountService);

        this.accountRepository = accountRepository;
        this.accountService_ = accountService;

        if (this.accountService_ == null)
            throw new RuntimeException("rrrrrrrr");

        accountService2 = accountService_;

        System.err.println(this + "CREATED2, " + this.accountRepository );
    }


    @RequestMapping(value = "/registration", method = RequestMethod.GET)
    private String registration(@ModelAttribute Account account)
    {
        System.err.println(this + "used0, " + this.accountService_);
        System.err.println(this + "used02, " + this.accountRepository);
        System.err.println(this + "used42, " + this.hello);

        return "account/registration";
    }


    @RequestMapping(value = "/registration", method = RequestMethod.POST)
    private String registration(@Valid @ModelAttribute Account account,
                                BindingResult bindingResult)
    {
        account.setRole("ROLE_USER");


        if (bindingResult.hasErrors())
            return "account/registration";

        System.err.println(this + "USED " + accountService_);


        if (accountService_ == null)
            throw new RuntimeException("1");

        if (account == null)
            throw new RuntimeException("2");


        accountService_.save(account);


        return "redirect:/login";
    }





    @RequestMapping(value = "account/current", method = RequestMethod.GET)
    @ResponseStatus(value = HttpStatus.OK)
    @ResponseBody
    @Secured({"ROLE_USER", "ROLE_ADMIN"})
    public Account currentAccount(Principal principal)
    {
        Assert.notNull(principal);
        return accountRepository.findOneByEmail(principal.getName());
    }


    @RequestMapping(value = "account/{id}", method = RequestMethod.GET)
    @ResponseStatus(value = HttpStatus.OK)
    @ResponseBody
    @Secured("ROLE_ADMIN")
    public Account account(@PathVariable("id") Long id)
    {
        return accountRepository.findOne(id);
    }


    public static class SignupForm
    {

        private static final String NOT_BLANK_MESSAGE = "{notBlank.message}";
        private static final String EMAIL_MESSAGE = "{email.message}";

        @NotBlank(message = NOT_BLANK_MESSAGE)
        @Email(message = EMAIL_MESSAGE)
        private String email;

        @NotBlank(message = NOT_BLANK_MESSAGE)
        private String password;


        public String getEmail()
        {
            return email;
        }


        public void setEmail(String email)
        {
            this.email = email;
        }


        public String getPassword()
        {
            return password;
        }


        public void setPassword(String password)
        {
            this.password = password;
        }


        public Account createAccount()
        {
            return new Account(getEmail(), getPassword(), "ROLE_USER");
        }
    }
}
